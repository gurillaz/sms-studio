<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoteRequest;
use App\Note;
use Carbon\Carbon;

use Illuminate\Http\Request;

class NoteController extends Controller
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
        /*
         * TODO remove this function, since notes belong to many Models
         *
         * */
    }

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
        $note->body= $validated['body'];
        $note->noteable_id= $validated['noteable_id'];
        $note->noteable_type= $validated['noteable_type'];
        $note->status= 'OK';
        $note->created_by= \Auth::id();

        $note->save();


        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        return view('note.note',compact('note',$note));
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
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        if(\request()->ajax()){

            $note->delete();
            $note->save();

            return ['status' => 'success', 'message' => '$Note deleted'];

        }
        $note->delete();
        $note->save();

        return redirect('/')->with('success','Note deleted');
    }

}
