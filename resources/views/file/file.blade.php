@extends('layouts.app')

@section('content')

    {{--    File Info Section--}}
    <section class="mb-5" id="client_info_section">

        <div class="d-sm-flex mb-4">

            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">Skedari</h1>

            <a href="#file_edit_collapse" data-toggle="collapse"  role="button" aria-expanded="false" aria-controls="file_edit_collapse"
               class="ml-auto btn btn-warning btn-icon-split mr-1 shadow-sm">
                        <span class="icon text-white-50">
                          <i class="fas fa-edit"></i>
                        </span>
                <span class="text">Ndrysho</span>
            </a>

            <a href="" class="btn btn-danger btn-icon-split shadow-sm"
               onclick="event.preventDefault();
                       if(confirm('Konfirmo fshirjen e fajllit')){
                        document.getElementById('deleteClient-form').submit();
                       }
                       ">
                        <span class="icon text-white-50">
                          <i class="fas fa-trash"></i>
                        </span>
                <span class="text">Fshij</span>
                <form id="deleteFile-form" action="{{$file->id}}" method="POST" style="display: none;">
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


                <div class="collapse @if($errors->count()!=0){{"show"}}@endif" id="file_edit_collapse">


                    <div class="card  border-left-warning shadow mb-4">
                        <div class="card-header">
                            Ndrysho te dhenat per fajllin
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{route('file.update',$file->id)}}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name">Emri i fajllit</label>
                                        <input type="text" class="form-control @error('name'){{ __('is-invalid')  }} @enderror" name="name" id="name" value="@if($errors->get('name')) {{old('name')}} @else {{$file->name }} @endif" placeholder="Emri i fajllit">
                                        @error("name")

                                        <strong class="invalid-feedback">{{ $message }}</strong>

                                        @enderror

                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="col-md-8 mb-3">
                                        <label for="description">Detaje</label>
                                        <textarea rows = "3" class="form-control @error('description'){{ __('is-invalid')  }} @enderror" name="description" id="description" value="@if($errors->get('description')) {{old('description')}} @else {{$file->description }} @endif"  placeholder="Detaje per fajllin"></textarea>

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


        <div class="row">


            <div class="col-md-12">

    {{--            <h1 class="h3 mb-2 text-gray-800"><span class="font-weight-bold text-uppercase">Klienti</span></h1>--}}

                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        Te dhenat per skedarin
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 col-sm-12">
                                <p class="font-weight-bold text-uppercase">Te dhenat kryesore:</p>

                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 col-xl-2">Emri:</div>
                                    <div class="col-auto font-weight-bold ">{{$file->name}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 col-xl-2">Pershkrimi:</div>
                                    <div class="col-auto font-weight-bold ">{{$file->description}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-3 col-md-12 col-lg-12 col-xl-12">Fajlli i takon:</div>
                                    <div class="col-auto font-weight-bold">
                                        <a href="/{{strtolower($file->belongs_to_model())}}/{{$file->fileable->id}}">{{$file->fileable->name}} ({{$file->belongs_to_model()}})</a>

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
                                    <div class="col-12">Madhesia(MB)</div>
                                    <div class="col-auto font-weight-bold ">{{$file->file_size()}} MB</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">Shtesa(lloji) i fajllit:</div>
                                    <div class="col-auto font-weight-bold ">{{$file->file_extension()}}({{$file->file_type()}})</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">Ngarkoi:</div>
                                    <div class="col-auto font-weight-bold ">{{explode(' ',trim($file->user->name))[0]}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">Date:</div>
                                    <div class="col-auto font-weight-bold ">{{\Carbon\Carbon::parse($file->created_at)->format('d.m.y h:i')}}</div>
                                </div>




                                <div class="row mb-3">
                                    <div class="col-12">Emri i skedarit te ruajtur:</div>
                                    <div class="col-auto small font-weight-bold">{{$file->file_name()}}</div>

                                </div>
                            </div>





                        </div>
                        <div class="row">
                            <div class="col-12">Shkarko:</div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <a href="{{route('file.download',$file->file)}}" class="btn btn-success btn-icon-split w-100 justify-content-start mt-1">
                                    <span class="icon text-white-100"><i class="fas fa-download"></i></span>
                                    <span class="text font-weight-bold mx-auto">Shkarko({{$file->file_extension()}} {{$file->file_size()}}MB)</span>
                                </a>
                            </div>

                        </div>


                    </div>
                </div>

            </div>


        </div>

    </section>
@endsection
