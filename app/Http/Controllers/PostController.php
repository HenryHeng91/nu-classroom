<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Enums\AccessEnum;
use App\Http\Controllers\Enums\PostTypeEnum;
use App\Http\Controllers\Enums\QuestionTypeEnum;
use App\Http\Controllers\Enums\StatusEnum;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\PostCreateRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\FriendUserResource;
use App\Http\Resources\PostResource;
use App\Models\AppUser;
use App\Models\Assignment;
use App\Models\ClassesStudent;
use App\Models\Comment;
use App\Models\Exam;
use App\Models\File;
use App\Models\Post;
use App\Models\Question;
use App\Models\VirtualClass;
use ContextHelper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $classmatesId = $user->classmates()->get()->pluck('user_id');
        $joinClassesIds = ClassesStudent::where('user_id', $user->id)->pluck('class_id');
        $posts = Post::whereIn('user_id', $classmatesId)->orWhere('class_id', $joinClassesIds)->orWhere('user_id', $user->id)->orderBy('created_at', 'desc');
        return PostResource::collection($posts->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostCreateRequest $request
     * @return PostResource
     */
    public function store(PostCreateRequest $request)
    {
        $user = AppUser::find(ContextHelper::GetRequestUserId());
        $class = VirtualClass::where('guid', $request->input('classId'))->first();

        //Saving new post:
        try{
            //opening transaction
            DB::beginTransaction();

            $newPost = new Post();
            $newPost->detail = $request->input('detail');
            $newPost->user_id = $user->id;
            $newPost->class_id = $class->id ?? null;
            $newPost->access = AccessEnum::getEnumByName($request->input('access'));
            $newPost->post_type = PostTypeEnum::getEnumByName($request->input('postType'));
            $newPost->status = StatusEnum::ACTIVE;
            $newPost->view_counts = 0;
            $newPost->like_count = 0;
            $newPost->guid = uniqid();

            if ($request->has('classwork.fileId')){
                $file = File::where('guid', $request->input('classwork.fileId'))->first();
                $newPost->file_id = $file->id;
            }

            $newPost->save();

            if ($request->has('classwork')) {
                $classwork = Post::ConvertRequestToClasswork($request);
                $classwork->post_id = $newPost->id;
                $newPost->classwork_id = $classwork->id ?? null;
            }
            $newPost->save();

            DB::commit();
            return new PostResource($newPost);
        }catch (Exception $e){
            DB::rollBack();
            throw $e;
//            return response('Server failure. Contact IT.', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return void
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function destroy(Post $post)
    {
        //
    }

    /**
     * List all user's own posts included questions, exams, assignments, announcements, etc.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
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
     * @param $classId
     * @return \Illuminate\Http\Response
     */
    public function getPostsOfClass($classId)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $class = VirtualClass::where('guid', $classId)->first();
        if (null == $class){
            return response('Requested class not found.', 400);
        }
        $posts = Post::where('class_id', $class->id)->orderBy('created_at', 'desc')->paginate();
        return PostResource::collection($posts);
    }

    /**
     * LIke a post
     *
     * @param $postId
     * @return \Illuminate\Http\Response
     */
    public function like($postId)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $post = Post::where('guid', $postId)->first();

        if (null == $post){
            return response("Requested post '$postId' not found.", 400);
        }

        if (!$post->likers->contains($user->id)){
            $post->like_count += 1;
            $post->save();
            $post->likers()->attach($user->id);
        }

        return response('', 200);
    }

    /**
     * LIke a post
     *
     * @param $postId
     * @return \Illuminate\Http\Response
     */
    public function unlike($postId)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $post = Post::where('guid', $postId)->first();

        if (null == $post){
            return response("Requested post '$postId' not found.", 400);
        }

        if (!$post->likers->contains($user->id)){
            return response("Requested user has not like this post '$postId'", 400);
        }

        $post->like_count -= 1;
        $post->likers()->detach($user->id);
        $post->save();
        return response('', 200);
    }

    /**
     * add view for a post
     *
     * @param $postId
     * @return \Illuminate\Http\Response
     */
    public function addView($postId)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $post = Post::where('guid', $postId)->first();

        if (null == $post){
            return response("Requested post '$postId' not found.", 400);
        }

        if (!$post->viewers->contains($user->id)){
            $post->view_counts += 1;
            $post->save();
            $post->viewers()->attach($user->id);
        }

        return response('', 200);
    }

    /**
     * add view for a post
     *
     * @param $postId
     * @return \Illuminate\Http\Response
     */
    public function getLikers($postId)
    {
        $post = Post::where('guid', $postId)->first();

        if (null == $post){
            return response("Requested post '$postId' not found.", 400);
        }

        return FriendUserResource::collection($post->viewers()->paginate());
    }



}
