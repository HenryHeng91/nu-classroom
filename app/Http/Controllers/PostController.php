<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Enums\AccessEnum;
use App\Http\Controllers\Enums\PostTypeEnum;
use App\Http\Controllers\Enums\StatusEnum;
use App\Http\Requests\PostCreateRequest;
use App\Http\Resources\PostResource;
use App\Models\AppUser;
use App\Models\Assignment;
use App\Models\ClassesStudent;
use App\Models\Exam;
use App\Models\File;
use App\Models\Post;
use App\Models\Question;
use App\Models\VirtualClass;
use ContextHelper;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

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
    public function store(PostCreateRequest $request)
    {
        $user = AppUser::find(ContextHelper::GetRequestUserId());
        $class = VirtualClass::where('guid', $request->input('classId'))->first();
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

        if ($request->has('fileId')){
            $newPost->file()->save(File::where('guid', $request->input('fileId'))->first());
        }

        $newPost->save();

        $classwork = null;
        if ($request->has('classwork')){
            switch (PostTypeEnum::getEnumByName($request->input('postType'))){
                case PostTypeEnum::ASSIGNMENT:
                    $classwork = new Assignment();
                    $classwork->title = $request->input('classwork.title');
                    $classwork->description = $request->input('classwork.description');
                    $classwork->post_id = $newPost->id;
                    $classwork->submit_count = 0;
                    $classwork->start_date = $request->input('classwork.startDate');
                    $classwork->end_date = $request->input('classwork.endDate');
                    $classwork->file_id = $request->input('classwork.file_id || null');
                    $classwork->guid = uniqid();
                    $classwork->save();
                    break;
                case PostTypeEnum::EXAM:
                    $classwork = new Exam();
                    $classwork->title = $request->input('classwork.title');
                    $classwork->description = $request->input('classwork.description');
                    $classwork->post_id = $newPost->id;
                    $classwork->submit_count = 0;
                    $classwork->start_date = $request->input('classwork.startDate');
                    $classwork->end_date = $request->input('classwork.endDate');
                    $classwork->file_id = $request->input('classwork.file_id || null');
                    $classwork->guid = uniqid();
                    $classwork->save();

                    $questions = array();
                    foreach ($request->input('questions') as $q){
                        $question = new Question();
                        $question->title = $q['title'];
                        $question->description = $q['description'];
                        $question->exam_id = $classwork->id;
                        $question->question_type = 1;
                        $question->point = 0;
                        $question->guid = uniqid();
                        array_push($questions, $question);
                    }

                    $classwork->questions()->saveMany($questions);
                    break;
                case PostTypeEnum::QUESTION:
                    $classwork = new Question();
                    $classwork->title = $request->input('classwork.title');
                    $classwork->description = $request->input('classwork.description');
                    $classwork->post_id = $newPost->id;
                    $classwork->question_type = 1;
                    $classwork->point = 0;
                    $classwork->guid = uniqid();
                    $classwork->save();
                    break;
                default:
                    $classwork = null;
            }
        }

        $newPost->classwork_id = $classwork->id ?? null;
        $newPost->save();
        return new PostResource($newPost);

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
        $posts = Post::where('class_id', $class->id)->paginate();
        return PostResource::collection($posts);
    }
}
