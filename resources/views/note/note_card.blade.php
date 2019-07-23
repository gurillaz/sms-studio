{{--Inside div row--}}

{{--Accepts $note named-variable--}}



<div class="col-xl-3 col-md-6 mb-4" id="note_card_{{$note->id}}">
    <div class="card bg-warning text-white shadow-sm">
        <div class="card-header bg-warning">
            <div class="btn-group-sm float-right">
                <a href="{{route('note.show',$note->id)}}" class="font-weight-bold text-uppercase btn-sm btn-outline-light">Detaje</a>

                <a href="" class="font-weight-bold text-uppercase btn-sm btn-outline-danger" onclick="event.preventDefault();
                    delete_note_card({{$note->id}})
                    ">Fshij
                </a>

            </div>
        </div>
        <div class="card-body">
            <p style="height: 1.5rem; line-height: 1rem">
            <a href="{{route('note.show',$note->id)}}" class="font-weight-bold text-uppercase text-white" >{{mb_strimwidth($note->name , 0, 45, '...')}}</a>
            </p>
            <p class="text-white mb-4" style="height: 12rem; line-height: 1.2rem">{{mb_strimwidth($note->body , 0, 305, '...')}}</p>



            <p class="small mt-3 mb-0 font-weight-light">Shtuar nga {{ explode(' ',trim($note->user->name))[0]}} me date {{\Carbon\Carbon::parse($note->created_at)->format('d.m.y')}}</p>
        </div>

    </div>
</div>