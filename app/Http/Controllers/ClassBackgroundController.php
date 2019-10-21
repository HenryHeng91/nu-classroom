<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassBackgroundResource;
use App\Models\ClassBackground;
use Illuminate\Http\Request;

class ClassBackgroundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ClassBackgroundResource::collection(ClassBackground::all());
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
     * @param  \App\Models\ClassBackground  $classBackground
     * @return \Illuminate\Http\Response
     */
    public function show(ClassBackground $classBackground)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassBackground  $classBackground
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassBackground $classBackground)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassBackground  $classBackground
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassBackground $classBackground)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassBackground  $classBackground
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassBackground $classBackground)
    {
        //
    }
}
