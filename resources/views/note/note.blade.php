@extends('layouts.app')

@section('content')

    {{--    Note Info Section--}}
    <section class="mb-5" id="client_info_section">

        <div class="d-sm-flex mb-4">

            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">Shenimi</h1>

            <a href="#note_edit_collapse" data-toggle="collapse"  role="button" aria-expanded="false" aria-controls="note_edit_collapse"
               class="ml-auto btn btn-warning btn-icon-split mr-1 shadow-sm">
                        <span class="icon text-white-50">
                          <i class="fas fa-edit"></i>
                        </span>
                <span class="text">Ndrysho</span>
            </a>

            <a href="" class="btn btn-danger btn-icon-split shadow-sm"
               onclick="event.preventDefault();
                       if(confirm('Konfirmo fshirjen e shenimit')){
                        document.getElementById('deleteNote-form').submit();
                       }
                       ">
                        <span class="icon text-white-50">
                          <i class="fas fa-trash"></i>
                        </span>
                <span class="text">Fshij</span>
                <form id="deleteNote-form" action="{{$note->id}}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            </a>

        </div>

        <div class="row">
            <div class="col-md-12">


                {{--
               If there are errors in Create Note request, defalut errors varibale gets errors from CreateNoterequest
               This to make error blade directive to work

               IGNORE the error
               --}}
                @php
                        $originalErrorBag = $errors;

                        if ($errors->updateClient->count()!=0){
                            $errors = $errors->updateClient;
                        }

                @endphp


                <div class="collapse @if($errors->count()!=0){{"show"}}@endif" id="note_edit_collapse">


                    <div class="card  border-left-warning shadow mb-4">
                        <div class="card-header">
                            Ndrysho te dhenat per shenimin
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{route('note.update',$note->id)}}">
                                @csrf

                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name">Emri</label>
                                        <input type="text" class="form-control @error('name'){{ __('is-invalid')  }} @enderror" name="name" id="name" value="@if($errors->get('name')) {{old('name')}} @else {{$note->name }} @endif" placeholder="Emri i shenimit">
                                        @error("name")

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror

                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="col-md-8 mb-3">
                                        <label for="body">Detaje</label>
                                        <textarea rows = "3" class="form-control @error('body'){{ __('is-invalid')  }} @enderror" name="body" id="body" value="@if($errors->get('body')) {{old('body')}} @else {{$note->body}} @endif"  placeholder="Pershkrimi">{{$note->body}}</textarea>

                                        @error('body')

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror
                                    </div>

                                </div>

                                <div class="form-row">

                                    <button class="btn btn-primary w-100" type="submit">Ruaj te dhenat</button>
                                </div>
                            </form>
                            {{--


                              IGNORE the error
                              --}}
                            @php
                                $errors = $originalErrorBag;


                            @endphp


                        </div>
                    </div>
                </div>


            </div>
        </div>


        <div class="row">


            <div class="col-md-12">

    {{--            <h1 class="h3 mb-2 text-gray-800"><span class="font-weight-bold text-uppercase">Klienti</span></h1>--}}

                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        Te dhenat per shenimin
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 col-sm-12">
                                <p class="font-weight-bold text-uppercase">Te dhenat kryesore:</p>

                                <div class="row mb-3">
                                    <div class="col-12">Emri:</div>
                                    <div class="col-auto font-weight-bold ">{{$note->name}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">Pershkrimi:</div>
                                    <div class="col-auto font-weight-bold ">{{$note->body}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">Shenimi i takon:</div>
                                    <div class="col-auto font-weight-bold">
                                        <a href="/{{strtolower($note->belongs_to_model())}}/{{$note->noteable->id}}">{{$note->noteable->name}} ({{$note->belongs_to_model()}})</a>

                                    </div>
                                </div>

{{--                                <div class="row mb-3">--}}
{{--                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 col-xl-2">u Shtu:</div>--}}
{{--                                    <div class="col-auto font-weight-bold ">Test Data</div>--}}

{{--                                </div>--}}
{{--                                <div class="row mb-3">--}}
{{--                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 col-xl-2">Adresa:</div>--}}
{{--                                    <div class="col-auto font-weight-bold ">Test Data</div>--}}
{{--                                </div>--}}

                            </div>


                            <div class="col-md-6 col-sm-12">
                                <p class="font-weight-bold text-uppercase">Te dhena tjera</p>


                                <div class="row mb-3">
                                    <div class="col-12">Krijoi:</div>
                                    <div class="col-auto font-weight-bold ">{{$note->user->name}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">Date:</div>
                                    <div class="col-auto font-weight-bold ">{{\Carbon\Carbon::parse($note->created_at)->format('d.m.y h:i')}}</div>
                                </div>

                            </div>





                        </div>


                    </div>
                </div>

            </div>


        </div>

    </section>
@endsection
