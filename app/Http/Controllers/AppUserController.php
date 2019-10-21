<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppUserUpdateRequest;
use App\Http\Resources\AppUserResource;
use App\Http\Resources\FriendUserResource;
use App\Http\Resources\PostResource;
use App\Models\AppUser;
use App\Models\Post;
use App\Services\FileServices\ImageService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AppUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppUser  $appUser
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $guid = $request->input('NU_CLASSROOM_USER.userId');
        $user = AppUser::where('guid', $guid)->first();
        return new AppUserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AppUser  $appUser
     * @return \Illuminate\Http\Response
     */
    public function edit(AppUser $appUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AppUser  $appUser
     * @return \Illuminate\Http\Response
     */
    public function update(AppUserUpdateRequest $request)
    {
        $validated = $request->validated();
        $userToUpdate = AppUser::find(\ContextHelper::GetRequestUserId());
        $userToUpdate->update(\ContextHelper::ToSnakeCase($request->all()));
        $userToUpdate->status = 2;
        $userToUpdate->save();
        return new AppUserResource($userToUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AppUser  $appUser
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $user->status = 4;
        $user->delete();
        return response('User Deleted', 200);
    }

    /**
     * Get all user's classmates.
     *
     * @param  \App\Models\AppUser  $appUser
     * @return \Illuminate\Http\Response
     */
    public function getClassmates()
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        return FriendUserResource::collection($user->classmates()->paginate());
    }

    /**
     * Get all user's posts even from any classes
     *
     * @param  \App\Models\AppUser  $appUser
     * @return \Illuminate\Http\Response
     */
    public function getPosts()
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());

        return PostResource::collection($user->posts);
    }

    /**
     * Get upload picture and set as profile picture for the request user.
     *
     * @param  \App\Models\AppUser  $appUser
     * @return AppUserResource
     */
    public function uploadProfilePic(Request $request)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());

        if (!$request->has('image_file')){
            return MakeHttpResponse(400, 'Fail', "No input name 'image_file' found!");
        }

        $destinationPath = public_path('images/avatars/');
        $defaultAvatar = 'avatar.png';
        $fileInput = $request->file('image_file');

        try{
            if ($user->profile_pic && $user->profile_pic != $defaultAvatar){
                File::delete($destinationPath.$user->profile_pic);
            }
            $imageService = new ImageService();

            $user->profile_pic = $imageService->SaveImageToPath($fileInput, $destinationPath, 'avatar-');
            $user->save();
        }catch (Exception $exception){
            return response($exception->getMessage(), 400);
        }
        return new AppUserResource($user);

    }
}
