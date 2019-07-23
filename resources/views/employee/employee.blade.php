@extends('layouts.app')

@section('content')

    {{--    Client Files Section--}}
    <section class="mb-5" id="client_info_section">

        <div class="d-sm-flex mb-4">

            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">Puntori</h1>

            <a href="#employee_edit_collapse" data-toggle="collapse"  role="button" aria-expanded="false" aria-controls="employee_edit_collapse"
               class="ml-auto btn btn-warning btn-icon-split mr-1 shadow-sm">
                        <span class="icon text-white-50">
                          <i class="fas fa-user-edit"></i>
                        </span>
                <span class="text">Ndrysho</span>
            </a>

            <a href="" class="btn btn-danger btn-icon-split shadow-sm"
               onclick="event.preventDefault();
                       if(confirm('Konfirmo fshirjen e puntorit')){
                        document.getElementById('deleteEmployee-form').submit();
                       }
                       ">
                        <span class="icon text-white-50">
                          <i class="fas fa-trash"></i>
                        </span>
                <span class="text">Fshij</span>
                <form id="deleteEmployee-form" action="{{$employee->id}}" method="POST" style="display: none;">
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

                        if ($errors->updateEmployee->count()!=0){
                            $errors = $errors->updateEmployee;
                        }

                @endphp


                <div class="collapse @if($errors->count()!=0){{"show"}}@endif" id="employee_edit_collapse">


                    <div class="card  border-left-warning shadow mb-4">
                        <div class="card-header">
                            Ndrysho te dhenat per puntorin
                        </div>
                        <div class="card-body">
                                <form method="post" action="{{route('employee.update',$employee->id)}}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="name">Emri dhe mbiemri</label>
                                            <input type="text" class="form-control @error('name'){{ __('is-invalid')  }} @enderror" name="name" id="name" value="@if($errors->get('name')) {{old('name')}} @else {{$employee->name}} @endif" placeholder="Emri dhe mbiemri">
                                            @error("name")

                                            <strong class="invalid-feedback">{{ $message }}</strong>

                                            @enderror

                                        </div>
                                    </div>
                                    <div class="form-row">

                                        <div class="col-md-4 mb-3">
                                            <label for="phone">Nr. i telefonit </label>
                                            <input type="text" class="form-control @error('phone'){{ __('is-invalid')  }} @enderror" name="phone" id="phone" value="@if($errors->get('phone')) {{old('phone')}} @else {{$employee->phone}} @endif" placeholder="Numri i telefoni">

                                            @error('phone')

                                            <strong class="invalid-feedback">{{ $message }}</strong>

                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-row">

                                        <div class="col-md-8 mb-3">
                                            <label for="address">Addresa</label>
                                            <input type="text" class="form-control @error('address'){{ __('is-invalid')  }} @enderror" name="address" id="address" value="@if($errors->get('address')) {{old('address')}} @else {{$employee->address}} @endif" placeholder="Adresa ne detaje"
                                            >

                                            @error('address')

                                            <strong class="invalid-feedback">{{ $message }}</strong>

                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-row">

                                        <div class="col-md-4 mb-3">
                                            <label for="position">Pozita</label>
                                            <input type="text" class="form-control @error('position'){{ __('is-invalid')  }} @enderror" name="position" id="position" value="@if($errors->get('position')) {{old('position')}} @else {{$employee->position}} @endif" placeholder="Pozita"
                                            >

                                            @error('position')

                                            <strong class="invalid-feedback">{{ $message }}</strong>

                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="col-12">
                                            <label for="salary_type">Pagesa </label>
                                        </div>
                                        <div class="col-md-4 mb-2">

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="salary_type" id="monthRadio" value="month" @if($employee->salary_type==='month'||old('salary_type')==='month')) checked @endif>
                                                <label class="form-check-label" for="monthRadio">Muaj</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="salary_type" id="dayRadio" value="day" @if($employee->salary_type==='day'||old('salary_type')==='day')) checked @endif>
                                                <label class="form-check-label" for="dayRadio">Dite</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="salary_type" id="hourRadio" value="hour" @if($employee->salary_type==='hour'||old('salary_type')==='hour')) checked @endif>
                                                <label class="form-check-label" for="hourRadio">Ore</label>
                                            </div>



                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">


                                            <input type="text" class="form-control @error('salary_amount'){{ __('is-invalid')  }} @enderror" name="salary_amount" id="salary_amount" value="@if($errors->get('salary_amount')) {{old('c')}} @else {{$employee->salary_amount}} @endif" placeholder="Shuma">


                                            @error('salary_type')


                                            <strong class="invalid-feedback">{{ $message }}</strong>

                                            @enderror
                                            @error('salary_amount')

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
                        Te dhenat per puntorin
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 col-sm-12">
                                <p class="font-weight-bold text-uppercase">Te dhenat personale:</p>

                                <div class="row mb-3">
                                    <div class="col-12">Emri:</div>
                                    <div class="col-auto font-weight-bold ">{{$employee->name}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">Telefon:</div>
                                    <div class="col-auto font-weight-bold ">{{$employee->phone}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">Adresa:</div>
                                    <div class="col-auto font-weight-bold ">{{$employee->address}}</div>
                                </div>

                            </div>


                            <div class="col-md-6 col-sm-12">
                                <p class="font-weight-bold text-uppercase">Te dhenat tjera:</p>
                                <div class="row mb-3">
                                    <div class="col-12">Pozita:</div>
                                    <div class="col-auto font-weight-bold ">{{$employee->position}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">Numri i eventeve</div>
                                    <div class="col-auto font-weight-bold ">{{$employee->no_events()}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">Pagesa:</div>
                                    <div class="col-auto font-weight-bold ">
                                        @if($employee->salary_type == 'hour')
                                            {{$employee->salary_amount}} - Ore
                                        @elseif($employee->salary_type == 'day')
                                            {{$employee->salary_amount}} - Dite
                                        @elseif($employee->salary_type == 'month')
                                            {{$employee->salary_amount}} - Muaj
                                        @else
                                            {{$employee->salary_amount}} - {{$employee->salary_type}}
                                        @endif

                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-12">Pagesa(Shuma gjithesej)</div>
                                    <div class="col-auto font-weight-bold ">{{$employee->payments_sum()}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">Statusi:</div>
                                    <div class="col-auto font-weight-bold ">{{$employee->status}}</div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-12">Detaje:</div>
                                    <div class="col-auto font-weight-light">Shtuar me date
                                        <span class="font-weight-bold">{{\Carbon\Carbon::parse($employee->created_at)->format('d.m.y')}}</span>
                                         nga
                                        <span class="font-weight-bold">{{$employee->user->name}}</span>
                                    </div>

                                </div>
                            </div>


                        </div>


                    </div>
                </div>

            </div>


        </div>

    </section>

    {{--    Employee Files Section--}}
    <section class="mb-5" id="employee_files_section">

        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">Fajllat e puntorit</h1>

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

                            <form method="post" action="{{route('file.store')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{$employee->id}}" name="fileable_id">

                                <input type="hidden" value="{{get_class($employee)}}" name="fileable_type">
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
        If Employee doesn't have files print Employee dosent have files

        else: print files cards

        --}}
        <div class="row">
            @if($employee->files->count()==0)

                    <div class="col-12 text-center">
                        <p class="h5 text-gray-600 font-weight-light my-5 ">Employee nuk ka fajlla te ruajtura</p>



                </div>


            @else

                    @foreach($employee->files as $file)

                        @include('file.file_card',['file'=>$file])

                    @endforeach

            @endif
        </div>
    </section>

    {{--    Employee Notes Section--}}
    <section class="mb-5" id="employee_notes_section">

        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">Shenimet per puntorin</h1>

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
                                <input type="hidden" value="{{$employee->id}}" name="noteable_id">
                                <input type="hidden" value="{{get_class($employee)}}" name="noteable_type">
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

        @foreach($employee->notes as $note)

            @include('note.note_card',['note'=>$note])

        @endforeach



    </div>
    </section>

    {{--    Employee Events Section--}}
    <section class="mb-5" id="employee_events_section">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">Rezervimet ku merr pjese puntori</h1>

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
                            <h1>Add Event</h1>
                            {{--
                            TODO Add "Add event. To be accesed from navigation bar on every page"
                            --}}


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
                        'events'=>$employee->events,
                        'tableName'=>"client_events_table"

                        ])

                    </div>
                </div>
            </div>

        </div>
    </section>


@endsection
