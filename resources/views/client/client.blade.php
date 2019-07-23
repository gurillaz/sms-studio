@extends('layouts.app')

@section('content')

    {{--    Client Files Section--}}
    <section class="mb-5" id="client_info_section">

        <div class="d-sm-flex mb-4">

            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">Klienti</h1>

            <a href="#client_edit_collapse" data-toggle="collapse"  role="button" aria-expanded="false" aria-controls="client_edit_collapse"
               class="ml-auto btn btn-warning btn-icon-split mr-1 shadow-sm">
                        <span class="icon text-white-50">
                          <i class="fas fa-user-edit"></i>
                        </span>
                <span class="text">Ndrysho</span>
            </a>

            <a href="" class="btn btn-danger btn-icon-split shadow-sm"
               onclick="event.preventDefault();
                       if(confirm('Konfirmo fshirjen e klientit')){
                        document.getElementById('deleteClient-form').submit();
                       }
                       ">
                        <span class="icon text-white-50">
                          <i class="fas fa-trash"></i>
                        </span>
                <span class="text">Fshij</span>
                <form id="deleteClient-form" action="{{$client->id}}" method="POST" style="display: none;">
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


                <div class="collapse @if($errors->count()!=0){{"show"}}@endif" id="client_edit_collapse">


                    <div class="card  border-left-warning shadow mb-4">
                        <div class="card-header">
                            Ndrysho te dhenat per klientin
                        </div>
                        <div class="card-body">
                                <form method="post" action="{{route('client.update',$client->id)}}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="name">Emri dhe mbiemri</label>
                                            <input type="text" class="form-control @error('name'){{ __('is-invalid')  }} @enderror" name="name" id="name" value="@if($errors->get('name')) {{old('name')}} @else {{$client->name}} @endif" placeholder="Emri dhe mbiemri">
                                            @error("name")

                                            <strong class="invalid-feedback">{{ $message }}</strong>

                                            @enderror

                                        </div>
                                    </div>
                                    <div class="form-row">

                                        <div class="col-md-4 mb-3">
                                            <label for="city">Qyteti</label>
                                            <input type="text" class="form-control @error('city'){{ __('is-invalid')  }} @enderror" name="city" id="city" value="@if($errors->get('city')) {{old('city')}} @else {{$client->city}} @endif"  placeholder="Qyteti/Komuna">

                                            @error('city')

                                            <strong class="invalid-feedback">{{ $message }}</strong>

                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-row">

                                        <div class="col-md-8 mb-3">
                                            <label for="address">Addresa</label>
                                            <input type="text" class="form-control @error('address'){{ __('is-invalid')  }} @enderror" name="address" id="address" value="@if($errors->get('address')) {{old('address')}} @else {{$client->address}} @endif" placeholder="Adresa ne detaje"
                                            >

                                            @error('address')

                                            <strong class="invalid-feedback">{{ $message }}</strong>

                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="phone">Nr. i telefonit </label>
                                            <input type="text" class="form-control @error('phone'){{ __('is-invalid')  }} @enderror" name="phone" id="phone" value="@if($errors->get('phone')) {{old('phone')}} @else {{$client->phone}} @endif" placeholder="Numri i telefoni">

                                            @error('phone')

                                            <strong class="invalid-feedback">{{ $message }}</strong>

                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="email">Email adresa </label>
                                            <input type="email" class="form-control @error('email'){{ __('is-invalid')  }} @enderror" name="email" id="email" value="@if($errors->get('email')) {{old('email')}} @else {{$client->email}} @endif" placeholder="Email Adresa">

                                            @error('email')

                                            <strong class="invalid-feedback">{{ $message }}</strong>

                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">

                                        <button class="btn btn-primary w-100" type="submit">Ruaj te dhenat</button>
                                    </div>
                                </form>

                            {{--
              If there are errors in Create Note request, defalut errors varibale gets errors from CreateNoterequest
              This to make error blade directive to work

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
                        Te dhenat per klientin
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 col-sm-12">
                                <p class="font-weight-bold text-uppercase">Te dhenat personale:</p>

                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 col-xl-2">Emri:</div>
                                    <div class="col-auto font-weight-bold ">{{$client->name}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 col-xl-2">Telefon:</div>
                                    <div class="col-auto font-weight-bold ">{{$client->phone}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 col-xl-2">Email:</div>
                                    <div class="col-auto font-weight-bold ">{{$client->email}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 col-xl-2">Qyteti:</div>
                                    <div class="col-auto font-weight-bold ">{{$client->city}}</div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 col-xl-2">Adresa:</div>
                                    <div class="col-auto font-weight-bold ">{{$client->address}}</div>
                                </div>

                            </div>


                            <div class="col-md-6 col-sm-12">
                                <p class="font-weight-bold text-uppercase">Te dhenat tjera:</p>

                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 col-xl-2">Rezervime:</div>
                                    <div class="col-auto font-weight-bold ">{{$client->no_events()}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 col-xl-2">Pagesa:</div>
                                    <div class="col-auto font-weight-bold ">{{$client->no_payments()}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">Pagesa(Gjithsej):</div>
                                    <div class="col-auto font-weight-bold ">{{$client->payments_sum()}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">Detaje:</div>
                                    <div class="col-auto font-weight-light">Shtuar me date
                                        <span class="font-weight-bold">{{\Carbon\Carbon::parse($client->created_at)->format('d.m.y')}}</span>
                                         nga
                                        <span class="font-weight-bold">{{$client->user->name}}</span>
                                    </div>

                                </div>
                            </div>


                        </div>


                    </div>
                </div>

            </div>


        </div>

    </section>

    {{--    Client Files Section--}}
    <section class="mb-5" id="client_files_section">

        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">Fajllat e klientit</h1>

            <a href="#add_file_collapse" data-toggle="collapse"  role="button" aria-expanded="false" aria-controls="add_file_collapse"
               class="ml-auto btn btn-primary btn-icon-split mr-1 shadow-sm">
                    <span class="icon text-white-50">
                      <i class="fas fa-plus"></i>
                    </span>
                <span class="text">Shto Fajll</span>
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

                    if ($errors->createFile->count()!=0){
                        $errors = $errors->createFile;
                    }

                @endphp
                <div class="collapse @if($errors->count()!=0){{"show"}}@endif" id="add_file_collapse">


                    <div class="card  border-left-primary shadow mb-4">
                        <div class="card-header">
                            Shto skedar
                        </div>
                        <div class="card-body">
                            {{$errors}}

                            <form method="post" action="{{route('file.store')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{$client->id}}" name="fileable_id">

                                <input type="hidden" value="{{get_class($client)}}" name="fileable_type">
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name">Emri i fajllit</label>
                                        <input type="text" class="form-control @error('name'){{ __('is-invalid')  }} @enderror" name="name" id="name" value="@if($errors->get('name')) {{old('name')}} @endif" placeholder="Emri i fajllit">
                                        @error("name")

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror

                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="col-md-8 mb-3">
                                        <label for="description">Detaje</label>
                                        <textarea rows = "3" class="form-control @error('description'){{ __('is-invalid')  }} @enderror" name="description" id="description" value="@if($errors->get('description')) {{old('description')}} @endif"  placeholder="Detaje per fajllin"></textarea>

                                        @error('description')

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name">Ngarko fajllin</label>

                                        <input type="file" class="form-control-file @error('name'){{ __('is-invalid')  }} @enderror" name="file" id="file" placeholder="Emri i fajllit">
{{--                                        <input type="text" class="form-control @error('name'){{ __('is-invalid')  }} @enderror" name="name" id="name" value="@if($errors->get('name')) {{old('name')}} @endif" placeholder="Emri i fajllit">--}}

                                        @error("file")

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



        {{--
        If Client doesn't have files print Client dosent have files

        else: print files cards

        --}}
        <div class="row">
            @if($client->files->count()==0)

                    <div class="col-12 text-center">
                        <p class="h5 text-gray-600 font-weight-light my-5 ">Klienti nuk ka fajlla te ruajtura</p>



                </div>


            @else

                    @foreach($client->files as $file)

                        @include('file.file_card',['file'=>$file])

                    @endforeach

            @endif
        </div>
    </section>

    {{--    Client Notes Section--}}
    <section class="mb-5" id="client_notes_section">

        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">Shenimet per klientin</h1>

            <a href="#add_note_collapse" data-toggle="collapse"  role="button" aria-expanded="false" aria-controls="add_note_collapse"
               class="ml-auto btn btn-primary btn-icon-split mr-1 shadow-sm">
                    <span class="icon text-white-50">
                      <i class="fas fa-plus"></i>
                    </span>
                <span class="text">Shto shenim</span>
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
                    if (isset($errors)){
                        if ($errors->createNote->count()!=0){
                            $errors = $errors->createNote;
                        }
                    }
                @endphp

                <div class="collapse @if($errors->count()!=0){{"show"}}@endif" id="add_note_collapse">


                    <div class="card  border-left-primary shadow mb-4">
                        <div class="card-header">
                            Shto shenim
                        </div>
                        <div class="card-body">

                            <form method="post" action="{{route('note.store')}}">
                                @csrf
                                <input type="hidden" value="{{$client->id}}" name="noteable_id">
                                <input type="hidden" value="{{get_class($client)}}" name="noteable_type">
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name">Emri i shenimit</label>
                                        <input type="text" class="form-control @error('name'){{ __('is-invalid')  }} @enderror" name="name" id="name" value="@if($errors->get('name')) {{old('name')}} @endif" placeholder="Emri i fajllit">
                                        @error("name")

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror

                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="col-md-8 mb-3">
                                        <label for="body">Detaje</label>
                                        <textarea rows = "3" class="form-control @error('body'){{ __('is-invalid')  }} @enderror" name="body" id="body" value="@if($errors->get('body')) {{old('body')}} @endif"  placeholder="Pershkrimi"></textarea>

                                        @error('body')

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror
                                    </div>

                                </div>

                                <div class="form-row">

                                    <button class="btn btn-primary w-100" type="submit">Ruaj te dhenat</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>


            </div>
        </div>

    <div class="row">

        @foreach($client->notes as $note)

            @include('note.note_card',['note'=>$note])

        @endforeach



    </div>
    </section>

    {{--    Client Events Section--}}
    <section class="mb-5" id="client_events_section">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">rezervimet e klientit</h1>

            <a href="#add_event_collapse" data-toggle="collapse"  role="button" aria-expanded="false" aria-controls="add_event_collapse"
               class="ml-auto btn btn-primary btn-icon-split mr-1 shadow-sm">
                    <span class="icon text-white-50">
                      <i class="fas fa-plus"></i>
                    </span>
                <span class="text">Shto rezervim</span>
            </a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="collapse @if($errors->count()!=0){{"show"}}@endif" id="add_event_collapse">


                    <div class="card  border-left-primary shadow mb-4">
                        <div class="card-header">
                            Shto skedar
                        </div>
                        <div class="card-body">

                            <form method="post" action="{{route('client.update',$client->id)}}">
                                @csrf
                                @method('PATCH')
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name">Emri dhe mbiemri</label>
                                        <input type="text" class="form-control @error('name'){{ __('is-invalid')  }} @enderror" name="name" id="name" value="@if($errors->get('name')) {{old('name')}} @else {{$client->name}} @endif" placeholder="Emri dhe mbiemri">
                                        @error("name")

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror

                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="col-md-4 mb-3">
                                        <label for="city">Qyteti</label>
                                        <input type="text" class="form-control @error('city'){{ __('is-invalid')  }} @enderror" name="city" id="city" value="@if($errors->get('city')) {{old('city')}} @else {{$client->city}} @endif"  placeholder="Qyteti/Komuna">

                                        @error('city')

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror
                                    </div>

                                </div>
                                <div class="form-row">

                                    <div class="col-md-8 mb-3">
                                        <label for="address">Addresa</label>
                                        <input type="text" class="form-control @error('address'){{ __('is-invalid')  }} @enderror" name="address" id="address" value="@if($errors->get('address')) {{old('address')}} @else {{$client->address}} @endif" placeholder="Adresa ne detaje"
                                        >

                                        @error('address')

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="phone">Nr. i telefonit </label>
                                        <input type="text" class="form-control @error('phone'){{ __('is-invalid')  }} @enderror" name="phone" id="phone" value="@if($errors->get('phone')) {{old('phone')}} @else {{$client->phone}} @endif" placeholder="Numri i telefoni">

                                        @error('phone')

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="email">Email adresa </label>
                                        <input type="email" class="form-control @error('email'){{ __('is-invalid')  }} @enderror" name="email" id="email" value="@if($errors->get('email')) {{old('email')}} @else {{$client->email}} @endif" placeholder="Email Adresa">

                                        @error('email')

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">

                                    <button class="btn btn-primary w-100" type="submit">Ruaj te dhenat</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="row">

            <div class="col-12">
                <div class="card shadow mb-4 w-100">
                    {{--            <div class="card-header py-3">--}}
                    {{--                <h6 class="m-0 font-weight-bold text-primary">Klientet</h6>--}}
                    {{--            </div>--}}
                    <div class="card-body">

                        @include('event.events_table',[
                        'events'=>$client->events,
                        'tableName'=>"client_events_table"

                        ])

                    </div>
                </div>
            </div>

        </div>
    </section>


@endsection
