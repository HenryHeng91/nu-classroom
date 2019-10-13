<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Enums\AccessEnum;
use App\Http\Controllers\Enums\FileTypeEnum;
use App\Http\Requests\FileCreateRequest;
use App\Http\Resources\FileResource;
use App\Models\AppUser;
use App\Models\File;
use App\Services\FileServices\FileService;
use ContextHelper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
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
    public function store(FileCreateRequest $request)
    {
        $fileService = new FileService();
        $uploadedFile = $request->file('file');

        $user = AppUser::find(ContextHelper::GetRequestUserId());
        $newFile = new File();
        $newFile->display_name = $request->input('name') ?? $uploadedFile->getFilename();
        $newFile->description = $request->input('description');
        $newFile->user_id = $user->id;
        $newFile->access = AccessEnum::getEnumByName($request->input('access')) ?? AccessEnum::PUBLIC;
        $newFile->file_type = $request->has('fileType') ? FileTypeEnum::getEnumByName($request->input('fileType')) : FileTypeEnum::DEFAULT;

        $path = "";
        try{
            switch ($newFile->file_type)
            {
                case FileTypeEnum::DEFAULT:
                    $newFile->file_extention = $uploadedFile->getClientOriginalExtension();
                    $newFile->file_name = sha1($uploadedFile->getFilename()).'.'.$newFile->file_extention;
                    $path = $fileService->saveUserFile($uploadedFile, $newFile->file_name);
                    $newFile->source = asset(env('FILEPATH_USER').'/'.$newFile->file_name);
                    break;
                case FileTypeEnum::LINK:
                    $newFile->file_extention = 'lnk';
                    $newFile->file_name = $request->input('source');
                    $path = $request->input('source');
                    $newFile->source = $request->input('source');
                    break;
                default:
                    return response("File type '$newFile->file_type' not applicable to upload.");
            }

        } catch (Exception $exception){
            if (null != $path && file_exists($path)){
                FileFacade::delete($path);
            }
        }

        $newFile->file_path = $path;
        $newFile->use_in = $request->input('useIn');
        $newFile->save();

        return new FileResource($newFile);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }
}
