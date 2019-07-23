@extends('layouts.app')

@section('content')





    <section class="mb-5" id="employees_section" style="min-height: 100vh">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light w-100 ">Te gjithe puntoret</h1>
            <input type="text" class="form-control col-2 mr-auto" id="employee_search_input" placeholder="Kerko puntoret" oninput="search_employees_cards(this.value)">
        </div>

        <div class="row">


            @foreach($employees as $employee)
                @include('employee.employee_card',['employee'=>$employee])
            @endforeach
{{--            <div class="card shadow mb-4 w-100">--}}
{{--                --}}{{--            <div class="card-header py-3">--}}
{{--                --}}{{--                <h6 class="m-0 font-weight-bold text-primary">Klientet</h6>--}}
{{--                --}}{{--            </div>--}}
{{--                <div class="card-body">--}}

{{--                    @include('client.clients_table',['clients'=>$clients])--}}

{{--                </div>--}}
{{--            </div>--}}

        </div>
    </section>


    <section class="mb-5" id="add_employee_section">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">Shto puntor te ri</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-left-primary shadow-sm mb-4 w-100 ">
                    <div class="card-body">

                        <form method="post" action="{{route('employee.store')}}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="name">Emri dhe mbiemri</label>
                                    <input type="text" class="form-control @error('name'){{ __('is-invalid')  }} @enderror" name="name" id="name" value="{{old('name')}}" placeholder="Emri dhe mbiemri">
                                    @error("name")

                                    <strong class="invalid-feedback">{{ $message }}</strong>

                                    @enderror

                                </div>
                            </div>
                            <div class="form-row">

                                <div class="col-md-4 mb-3">
                                    <label for="phone">Nr. i telefonit </label>
                                    <input type="text" class="form-control @error('phone'){{ __('is-invalid')  }} @enderror" name="phone" id="phone" value="{{old('phone')}}" placeholder="Numri i telefoni">

                                    @error('phone')

                                    <strong class="invalid-feedback">{{ $message }}</strong>

                                    @enderror
                                </div>

                            </div>
                            <div class="form-row">

                                <div class="col-md-8 mb-3">
                                    <label for="address">Addresa</label>
                                    <input type="text" class="form-control @error('address'){{ __('is-invalid')  }} @enderror" name="address" id="address" value="{{old('address')}}" placeholder="Adresa ne detaje"
                                    >

                                    @error('address')

                                    <strong class="invalid-feedback">{{ $message }}</strong>

                                    @enderror
                                </div>

                            </div>
                            <div class="form-row">

                                <div class="col-md-4 mb-3">
                                    <label for="position">Pozita</label>
                                    <input type="text" class="form-control @error('position'){{ __('is-invalid')  }} @enderror" name="position" id="position" value="{{old('position')}}" placeholder="Pozita"
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
                                        <input class="form-check-input" type="radio" name="salary_type" id="monthRadio" value="month" @if(old('salary_type')==='month') checked @endif>
                                        <label class="form-check-label" for="monthRadio">Muaj</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="salary_type" id="dayRadio" value="day" @if(old('salary_type')==='day') checked @endif>
                                        <label class="form-check-label" for="dayRadio">Dite</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="salary_type" id="hourRadio" value="hour" @if(old('salary_type')==='hour') checked @endif>
                                        <label class="form-check-label" for="hourRadio">Ore</label>
                                    </div>



                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">


                                    <input type="text" class="form-control @error('salary_month'){{ __('is-invalid')  }} @enderror" name="salary_month" id="salary_month" value="{{old('salary_month')}}" placeholder="Shuma">


                                    @error('salary_type')


                                    <strong class="invalid-feedback">{{ $message }}</strong>

                                    @enderror
                                    @error('salary_month')

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
    </section>

{{--    <section class="mb-5" id="deleted_clients_section" style="min-height: 100vh">--}}
{{--        <div class="d-sm-flex mb-4">--}}
{{--            <h1 class="h3 mb-0 text-gray-800 text-uppercase font-weight-light">Te gjithe klientet</h1>--}}
{{--        </div>--}}

{{--        <div class="row">--}}

{{--            <div class="card shadow mb-4 w-100">--}}
{{--                --}}{{--            <div class="card-header py-3">--}}
{{--                --}}{{--                <h6 class="m-0 font-weight-bold text-primary">Klientet</h6>--}}
{{--                --}}{{--            </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="table-responsive">--}}

{{--                        <table id="deleted_clientsTable" class="table table-sm table-striped table-bordered">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>Emri</th>--}}
{{--                                <th>Telefoni</th>--}}
{{--                                <th>Qyteti</th>--}}

{{--                                <th>Shtuar me:</th>--}}

{{--                                <th>Veprimet</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($deleted_clients as $client)--}}
{{--                                <tr id="client_{{$client->id}}">--}}
{{--                                    <td>{{$client->name}}</td>--}}
{{--                                    <td>{{$client->phone}}</td>--}}
{{--                                    <td>{{$client->city}}</td>--}}

{{--                                    <td>{{$client->created_at}}</td>--}}
{{--                                    <td>--}}
{{--                                        <div class="btn-group-sm text-center">--}}
{{--                                            <a href="client/{{$client->id}}"--}}
{{--                                               class="font-weight-bold text-uppercase  btn-sm btn-outline-primary">Shiqo</a>--}}
{{--                                            <a href=""--}}
{{--                                               class="font-weight-bold text-uppercase  btn-sm btn-outline-danger"--}}
{{--                                               onclick="event.preventDefault();--}}
{{--                                                       if(confirm('Konfirmo fshirjen e klientit')){--}}
{{--                                                       axios({--}}
{{--                                                       method: 'post',--}}
{{--                                                       url: '/client/'+'{{$client->id}}',--}}
{{--                                                       data: {--}}
{{--                                                       _method: 'DELETE'--}}
{{--                                                       }--}}
{{--                                                       }).then(function () {--}}

{{--                                                       clientsTable.row( $('#client_{{$client->id}}')).remove();--}}
{{--                                                       clientsTable.draw();--}}
{{--                                                       // location.reload();--}}

{{--                                                       })--}}
{{--                                                       .catch(function (error) {--}}
{{--                                                       console.log(error);--}}
{{--                                                       });--}}

{{--                                                       }--}}


{{--                                                       ">Fshij</a>--}}


{{--                                        </div>--}}
{{--                                    </td>--}}

{{--                                </tr>--}}

{{--                            @endforeach--}}


{{--                            </tbody>--}}
{{--                        </table>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </section>--}}
@endsection