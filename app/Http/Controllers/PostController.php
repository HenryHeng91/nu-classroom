<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\AppUser;
use App\Models\ClassesStudent;
use App\Models\Post;
use App\Models\VirtualClass;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $classmatesId = $user->classmates()->pluck('id');
        $joinClassesIds = ClassesStudent::where('user_id', $user->id)->pluck('class_id');
        $posts = Post::whereIn('user_id', $classmatesId)->orWhere('class_id', $joinClassesIds)->orWhere('user_id', $user->id)->orderBy('created_at', 'desc');
        return PostResource::collection($posts->paginate());
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
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    /**
     * List all user's own posts included questions, exams, assignments, announcements, etc.
     *
     * @param  \App\Models\AppUser  $appUser
     * @return \Illuminate\Http\Response
     */
    public function getUserCreatedPosts()
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $posts = $user->posts()->orderBy('created_at', 'desc');
        return PostResource::collection($posts->paginate());
    }

    /**
     * List all posts in the class.
     *
     * @param  \App\Models\AppUser  $appUser
     * @return \Illuminate\Http\Response
     */
    public function getPostsOfClass($classId)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $class = VirtualClass::where('guid', $classId)->first();
        if (null == $class){
            return response('Requested class not found.', 400);
        }
        $posts = Post::where('class_id', $class->id);
        return PostResource::collection($posts->paginate());
    }
}
