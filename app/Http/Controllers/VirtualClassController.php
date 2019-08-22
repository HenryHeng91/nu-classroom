<?php

namespace App\Http\Controllers;

use App\Http\Requests\VirtualClassCreationRequest;
use App\Http\Resources\VirtualClassResource as VirtualClassResource;
use App\Models\AppUser;
use App\Models\Category;
use App\Models\ClassBackground;
use App\Models\Organization;
use App\Models\VirtualClass;
use ContextHelper;
use Illuminate\Http\Request;

class VirtualClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = ContextHelper::GetRequestUserId();
        $classes = VirtualClass::getAllClasses($userId)->paginate();
        return VirtualClassResource::collection($classes);
    }

    /**
     * Return list of user's created classes
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreatedClasses()
    {
        $userId = ContextHelper::GetRequestUserId();
        $classes = AppUser::find($userId)->createdClasses;
        return VirtualClassResource::collection($classes);
    }

    /**
     * Return list of user's joined classes
     *
     * @return \Illuminate\Http\Response
     */
    public function getJoinedClasses()
    {
        $userId = ContextHelper::GetRequestUserId();
        $classes = AppUser::find($userId)->joinClasses;
        return VirtualClassResource::collection($classes);
    }

    /**
     * Join a class
     *
     * @return \Illuminate\Http\Response
     */
    public function joinClass($classGuid)
    {
        $user = AppUser::find(ContextHelper::GetRequestUserId());
        $class = VirtualClass::where('guid', $classGuid)->firstOrFail();

        if (null == $class)
        {
            return response('Requested class not found.', 400);
        }

        if (!$class->students->contains($user)){
            $class->students()->save($user);
            $class->members_count += 1;
            $class->save();
        }

        return response('OK', 200);
    }

    /**
     * Left a class
     *
     * @return \Illuminate\Http\Response
     */
    public function leftClass($classGuid)
    {
        $user = AppUser::find(ContextHelper::GetRequestUserId());
        $class = VirtualClass::where('guid', $classGuid)->firstOrFail();

        if (null == $class)
        {
            return response('Requested class not found.', 400);
        }

        if (!$class->students->contains($user)){
            return response('You are not a member of this class!', 400);
        }

        $user->joinClasses()->detach($class);
        $class->members_count -= 1;
        $class->save();
        return response('OK', 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(VirtualClassCreationRequest $request)
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
        $user = AppUser::find(ContextHelper::GetRequestUserId());
        $newClass = new VirtualClass();
        $newClass->class_title = $request->input('classTitle');
        $newClass->description = $request->input('description');
        $newClass->category()->associate(Category::where('guid', $request->input('categoryId'))->first());

        if ($request->has('organizationId')){
            $newClass->organization()->associate(Organization::where('guid', $request->input('organizationId'))->first());
        }
        if ($request->has('classBackgroundsId')){
            $newClass->classBackground()->associate(ClassBackground::where('guid', $request->input('classBackgroundsId'))->first());
        }

        $newClass->start_date = $request->input('startDate') ?? now();
        $newClass->end_date = $request->input('endDate');
        $newClass->class_start_time = $request->input('classStartTime') ?? null;
        $newClass->class_end_time = $request->input('classEndTime') ?? null;
        $newClass->class_days = $request->input('classDays') ?? null;
        $user->createdClasses()->save($newClass);

        return new VirtualClassResource($newClass);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VirtualClass  $virtualClass
     * @return \Illuminate\Http\Response
     */
    public function show($classGuid)
    {
        $class = VirtualClass::where('guid', $classGuid)->first();
        if (null == $class){
            return response('Requested class not found.', 400);
        }
        return new VirtualClassResource($class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VirtualClass  $virtualClass
     * @return \Illuminate\Http\Response
     */
    public function edit(VirtualClass $virtualClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VirtualClass  $virtualClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VirtualClass $virtualClass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VirtualClass  $virtualClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(VirtualClass $virtualClass)
    {
        //
    }
}
