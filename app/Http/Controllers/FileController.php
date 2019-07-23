<?php

namespace App\Http\Controllers;

use App\file;
use App\Http\Requests\CreateFileRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
    public function store(CreateFileRequest $request)
    {
        $validated = $request->validated();

        $file = new File();

        $file->name = $validated['name'];
        $file->description= $validated['description'];


        $file->fileable_id= $validated['fileable_id'];
        $file->fileable_type= $validated['fileable_type'];


        $file ->created_by= \Auth::id();



        $path = $request->file('file')
            ->storeAs(
                'uploads',
                strtoupper(str_replace(' ','_',$validated['name'])).'-'.str_replace(' ','_',$request->file('file')->getClientOriginalName()));

        $file->file = basename($path);


        $file ->save();


        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {

        return view('file.file',compact('file',$file));

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
    public function update(Request $request, file $file)
    {
        //
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

        return redirect('/file')->with('success','File deleted');
    }


    public function destroyAjax($fileId)
    {

        $file= File::findOrFail($fileId);

        $file->delete();
        $file->save();

        return ['status'=>'success','message'=>'File deleted'];


    }





    public function download($filename){


        $file_path = storage_path("app\\uploads\\").$filename;

        if (file_exists($file_path))
        {
            // Send Download
            return \Response::download($file_path, $filename, [
                'Content-Length: '. filesize($file_path)
            ]);
        }
        else
        {
            // Error
            return 'File not found';
        }
    }




}
