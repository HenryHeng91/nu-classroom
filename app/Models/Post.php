<?php

namespace App\Models;

use App\Http\Controllers\Enums\PostTypeEnum;
use App\Http\Controllers\Enums\QuestionTypeEnum;
use App\Http\Requests\PostCreateRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    public function user(){
        return $this->belongsTo('App\Models\AppUser', 'user_id');
    }

    public function class(){
        return $this->belongsTo('App\Models\VirtualClass', 'class_id');
    }

    public function classWorks(){
        switch ($this->post_type){
            case PostTypeEnum::ASSIGNMENT:
                return Assignment::find($this->classwork_id);
            case PostTypeEnum::EXAM:
                return Exam::find($this->classwork_id);
            case PostTypeEnum::QUESTION:
                return Question::find($this->classwork_id);
            default:
                return null;
        }
    }

    public function file(){
        return $this->hasOne('App\Models\File', 'id', 'file_id');
    }

    public function viewers(){
        return $this->belongsToMany('App\Models\AppUser', 'post_views', 'post_id', 'user_id');
    }

    public function likers(){
        return $this->belongsToMany('App\Models\AppUser', 'post_likes', 'post_id', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * Convert request dto to classwork dto
     *
     * @param PostCreateRequest $request
     * @param Post $newPost
     * @return $classwork
     */
    public static function ConvertRequestToClasswork(PostCreateRequest $request)
    {
        $type = PostTypeEnum::getEnumByName($request->input('postType'));
        switch ($type) {
            case PostTypeEnum::ASSIGNMENT:
                $classwork = new Assignment();
                break;
            case PostTypeEnum::EXAM:
                $classwork = new Exam();
                break;
            case PostTypeEnum::QUESTION:
                $classwork = new Question();
                $classwork->question_type = QuestionTypeEnum::getEnumByName($request->input('classwork.questionType'));
                $classwork->point = 0;
                break;
            default:
                $classwork = null;
        }

        $classwork->title = $request->input('classwork.title');
        $classwork->description = $request->input('classwork.description');
        $classwork->guid = uniqid();

        if ($type == PostTypeEnum::ASSIGNMENT || $type == PostTypeEnum::EXAM){
            $classwork->start_date = $request->input('classwork.startDate');
            $classwork->end_date = $request->input('classwork.endDate');
            $classwork->file_id = $request->input('classwork.fileId') || null;
        }

        $classwork->save();

        //Save classwork's related objects
        if ($type != PostTypeEnum::POST){
            self::SaveClassworks($request, $classwork);
        }

        return $classwork;
    }

    private static function SaveClassworks($request, $classwork){
        $type = PostTypeEnum::getEnumByName($request->input('postType'));
        switch ($type){
            case PostTypeEnum::EXAM:
                $classwork->questions()->saveMany(Question::getQuestionsFromRequest($request));
                break;
            case PostTypeEnum::QUESTION:
                $classwork->answers()->saveMany(Question::getAnswersFromRequest($request));
                break;
            default:
                break;

        }
    }
}
