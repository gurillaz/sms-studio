<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\CreateFileRequest;
use App\Http\Requests\UpdateFileRequest;

//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response;
use Storage as Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $files = File::all();

        $files_map = $files->map(function ($file) {

            $data = $file->only(['id', 'name', 'created_at', 'updated_at']);
            $data['created_by'] = $file->user->only('name');
            $data['file_extension'] = $file->file_extension();
            $data['file_type'] = $file->file_type();
            $data['file_type'] = $file->file_type();
            $data['file_size'] = $file->file_size();
            $data['file_name'] = $file->file_name();
            $data['belongs_to'] = $file->fileable->only(['id', 'name']);
            $data['model'] = explode('\\', trim($file->fileable_type))[1];
            return $data;
        });


        return Response::json([
            'files' => $files_map
        ], 200);
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
    public function store(CreateFileRequest $request)
    {
        $validated = $request->validated();

        $file = new File();

        $file->name = $validated['name'];
        $file->description = $validated['description'];


        $file->fileable_id = $validated['fileable_id'];
        $file->fileable_type = $validated['fileable_type'];


        $file->created_by = \Auth::id();

        $fileName = strtoupper(str_replace(' ', '_', $validated['name'])) . '-' . str_replace(' ', '_', $request->file('file')->getClientOriginalName());


        Storage::putFileAs('public/uploads', $request->file('file'), $fileName);


        $file->file = basename($fileName);


        $file->save();

        return Response::json([
            'file' => $file,
            'message' => "File saved!"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {



        $data = [];

        $data = $file->only(['id', 'name', 'description', 'created_at', 'updated_at']);
        $data['created_by'] = $file->user->only('name');
        $data['file_extension'] = $file->file_extension();
        $data['file_type'] = $file->file_type();
        $data['file_type'] = $file->file_type();
        $data['file_size'] = $file->file_size();
        $data['file_name'] = $file->file_name();
        $data['belongs_to'] = $file->fileable->only(['id', 'name']);
        $data['model'] = explode('\\', trim($file->fileable_type))[1];

        return Response::json([
            'file' => $data,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\file  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(file $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\file  $file
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        // return $request->all();
        $validated = $request->validated();

        $file->name = $validated['name'];
        $file->description = $validated['description'];


        /* TODO Delete previous File */


        $file->created_by = \Auth::id();


        //If new file exists in request
        if ($request->file('file')!=null) {

            $fileName = strtoupper(str_replace(' ', '_', $validated['name'])) . '-' . str_replace(' ', '_', $request->file('file')->getClientOriginalName());


            Storage::putFileAs('public/uploads', $request->file('file'), $fileName);


            $file->file = basename($fileName);
        }

        $file->save();

        $data = [];

        $data = $file->only(['id', 'name', 'description', 'created_at', 'updated_at']);
        $data['created_by'] = $file->user->only('name');
        $data['file_extension'] = $file->file_extension();
        $data['file_type'] = $file->file_type();
        $data['file_type'] = $file->file_type();
        $data['file_size'] = $file->file_size();
        $data['file_name'] = $file->file_name();
        $data['belongs_to'] = $file->fileable->only(['id', 'name']);
        $data['model'] = explode('\\', trim($file->fileable_type))[1];

        return Response::json([
            'file' => $data,
            'message' => 'File updated!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\file  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {

        $file->delete();
        $file->save();

        return Response::json([
            'message' => 'File deleted!'
        ], 200);
    }


    public function checkIfFileExists($filename)
    {

        // this might throw errors in future, check if filee should be saved in app/storage or in public folder
        $file_path = storage_path("app\\public\\uploads\\") . $filename;


        if (file_exists($file_path)) {


            return Response::json([
                'message' => 'File found!',
                'path' => "/download/" . $filename
            ], 200);
        } else {
            return Response::json([
                'message' => 'File not found',
                'errors' => "File not found",
                'errors' => $file_path
            ], 404);
        }
    }

    public function downloadFile($filename)
    {


        $file_path = storage_path("app\\public\\uploads\\") . $filename;

        if (file_exists($file_path)) {
            // Send Download Response
            return \Response::download($file_path, $filename, [
                'Content-Length: ' . filesize($file_path)
            ]);
        }

        return "asddas";
    }
}
