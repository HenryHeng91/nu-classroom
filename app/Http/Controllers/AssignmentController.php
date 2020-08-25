<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Enums\QuestionTypeEnum;
use App\Http\Requests\SubmitAssignmentRequest;
use App\Http\Requests\SubmitQuestionRequest;
use App\Models\Answer;
use App\Models\AppUser;
use App\Models\Assignment;
use App\Models\AssignmentSubmit;
use App\Models\File;
use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;

class AssignmentController extends Controller
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
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        //
    }
    /**
     * Submit assignment
     *
     * @param SubmitQuestionRequest $request
     * @return void
     */
    public function submitAssignment(SubmitAssignmentRequest $request)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $assignmentId = $request->input('assignmentId');
        $assignment = Assignment::where('guid', $assignmentId)->first();

        if(!$assignment->post->class->students->contains($user)){
            return response("This user doesn't have right to answer this question with id '$assignmentId'", 400);
        }

        if (!$this->isAssignmentSubmittable($assignment)){
            return response("Assignment with id '$assignmentId' deadline has passed or not available to for submit yet.", 400);
        }

        if (AssignmentSubmit::where('user_id', $user->id)->where('assignment_id', $assignment->id)){
            return response("Assignment with id '$assignmentId' already submitted by this user '$user->guid'", 400);
        }

        $submit = new AssignmentSubmit();
        $submit->user_id = $user->id;
        $submit->guid = uniqid();
        $submit->file_id = File::where('guid', $request->input('fileId'))->first()->id;

        $assignment->assignmentSubmits()->save($submit);
        $assignment->submit_count += 1;
        $assignment->update();

        return response("OK", 200);
    }

    /**
     * @param $assignment
     * @return bool
     */
    private function isAssignmentSubmittable($assignment): bool
    {
        return now() >= $assignment->start_date && now() <= $assignment->end_date;
    }

}
