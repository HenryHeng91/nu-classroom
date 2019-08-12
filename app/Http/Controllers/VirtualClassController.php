<?php

namespace App\Http\Controllers;

use App\Http\Resources\VirtualClassResource as VirtualClassResource;
use App\Models\AppUser;
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
        }

        return response('OK', 200);
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
     * @param  \App\Models\VirtualClass  $virtualClass
     * @return \Illuminate\Http\Response
     */
    public function show(VirtualClass $virtualClass)
    {
        //
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
