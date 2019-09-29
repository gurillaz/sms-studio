<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Note;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::all();
 
        $noted_map = $notes->map(function($note){

                $data = $note->only(['id','name','created_at','updated_at']);
                $data['created_by'] = $note->user->only('name');
                $data['belongs_to'] = $note->noteable->only(['id','name']);
                $data['model'] = explode('\\', trim($note->noteable_type))[1];
                return $data;
        });


        return Response::json([
            'notes' => $noted_map
        ], 200);
    }

    /**
     * Show the form for creating a new resource.   
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*
         * TODO remove this function, since notes belong to many Models
         *
         * */ }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNoteRequest $request)
    {
        $validated = $request->validated();

        //        return $validated;
        $note = new Note();

        $note->name = $validated['name'];
        $note->body = $validated['body'];
        $note->noteable_id = $validated['noteable_id'];
        $note->noteable_type = $validated['noteable_type'];
        $note->status = 'OK';
        /*TODO Set created by, from authenticated user*/
        $note->created_by = Auth::id();

        $note->save();


        return Response::json([
            'note' => $note,
            'message' => "Note addetd!"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        // $note->created_by = $note->user->name;

        $data =  $note->only(['id', 'name', 'body', 'status', 'created_at', 'updated_at', 'noteable_type', 'noteable_id']);
        $created_by = $note->user->only(['name']);
        $belongs_to = $note->noteable->only(['id', 'name']);
        $model = explode('\\', trim($note->noteable_type))[1];



        return Response::json([
            'note' => $data,
            'created_by' => $created_by,
            'belongs_to' => $belongs_to,
            'model' => $model,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $validated = $request->validated();



        $note->name = $validated['name'];
        $note->body = $validated['body'];

        $note->created_by = Auth::id();

        $note->save();

        $data =  $note->only(['id', 'name', 'body', 'status', 'created_at', 'updated_at', 'noteable_type', 'noteable_id']);

        return Response::json([
            'note' => $data,
            'message' => "Note udpated!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {

        $note->delete();
        $note->save();

        return Response::json([
            'message' => "Note deleted!"
        ], 200);

        //        return redirect('/')->with('success','Note deleted');
    }
}
