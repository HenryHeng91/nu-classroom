<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppUserUpdateRequest;
use App\Http\Resources\AppUserResource;
use App\Models\AppUser;
use http\Exception;
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
     * Get upload picture and set as profile picture for the request user.
     *
     * @param  \App\Models\AppUser  $appUser
     * @return \Illuminate\Http\Response
     */
    public function uploadprofilepic(Request $request)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());

        if (!$request->has('image_file')){
            return MakeHttpResponse(400, 'Fail', "No input name 'image_file' found!");
        }

        $fileInput = $request->file('image_file');
        $destinationPath = public_path('images/avatars/');
        $defaultAvatar = 'avatar.png';

        $validator = Validator::make(array('image_file'=>$fileInput), ['image_file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:10240']);
        if ($validator->fails()){
            return MakeHttpResponse(400, 'Fail', $validator->errors()->all());
        }
        try{
            if ($user->profile_pic && $user->profile_pic != $defaultAvatar){
                File::delete($destinationPath.$user->profile_pic);
            }

            $user->profile_pic = \ContextHelper::SaveImageToPath($fileInput, $destinationPath, 'avatar-');
            $user->save();
        }catch (Exception $exception){
            return MakeHttpResponse(400, 'Fail', $exception->getMessage());
        }
        return new AppUserResource($user);

    }
}
