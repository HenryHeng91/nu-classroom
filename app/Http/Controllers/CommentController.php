<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\AppUser;
use App\Models\Comment;
use App\Models\File;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($postId)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $post = Post::where('guid', $postId)->first();

        if (null == $post){
            return response("Requested post '$postId' not found.", 400);
        }

        return CommentResource::collection($post->comments);
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
    public function store(AddCommentRequest $request, $postId)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $post = Post::where('guid', $postId)->first();

        if (null == $post){
            return response("Requested post '$postId' not found.", 400);
        }

        try
        {
            $newComment = new Comment();
            $newComment->user_id = $user->id;
            $newComment->post_id = $post->id;
            $newComment->comment_detail = $request->input('commentDetail');
            $newComment->file_id = File::where('guid', $request->input('fileId'))->first()->id ?? null;
            $newComment->like_count = 0;
            $newComment->guid = uniqid();
            $newComment->save();
            $post->comments()->save($newComment);
            return new PostResource($post);

        }
        catch (\Exception $e)
        {
            return response("Server error. Contact IT.", 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($commentId)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $comment = Comment::where('guid', $commentId)->first();
        if (null == $comment){
            return response("Comment with id '$commentId' not found.", 400);
        }

        if ($comment->user == $user || $comment->post->user == $user){
            if ($comment->delete()){
                return response("Comment with id '$commentId' deleted.", 200);
            }
        }

        return response("No sufficient right to delete comment with ID '$commentId'.", 400);
    }
}
