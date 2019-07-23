@extends('layouts.app')

@section('content')

    <section class="mb-5" id="clients_section" style="min-height: 100vh">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-uppercase w-100 ">Te gjithe klientet</h1>
            <input type="text" class="form-control col-2 mr-auto" id="clients_search_input" placeholder="Kerko klientet" oninput="search_clients_cards(this.value)">
        </div>

        <div class="row">


            @foreach($clients as $client)
                @include('client.client_card',['client'=>$client])
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

    <section class="mb-5" id="add_client_section" style="min-height: 100vh">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-uppercase">Shto klient te ri</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-left-primary shadow-sm mb-4 w-100 ">
                    <div class="card-body">
                        <form method="post" action="{{route('client.store')}}">
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
                                    <label for="city">Qyteti</label>
                                    <input type="text" class="form-control @error('city'){{ __('is-invalid')  }} @enderror" name="city" id="city" value="{{old('city')}}"  placeholder="Qyteti/Komuna">

                                    @error('city')

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
                                    <label for="phone">Nr. i telefonit </label>
                                    <input type="text" class="form-control @error('phone'){{ __('is-invalid')  }} @enderror" name="phone" id="phone" value="{{old('phone')}}" placeholder="Numri i telefoni">

                                    @error('phone')

                                    <strong class="invalid-feedback">{{ $message }}</strong>

                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="email">Email adresa </label>
                                    <input type="email" class="form-control @error('email'){{ __('is-invalid')  }} @enderror" name="email" id="email" value="{{old('email')}}" placeholder="Email Adresa">

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
    </section>

    <section class="mb-5" id="deleted_clients_section" style="min-height: 100vh">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-uppercase">Klientet e fshire</h1>
        </div>

        <div class="row">

            <div class="card shadow mb-4 w-100">
                {{--            <div class="card-header py-3">--}}
                {{--                <h6 class="m-0 font-weight-bold text-primary">Klientet</h6>--}}
                {{--            </div>--}}
                <div class="card-body">
{{--                    {{Request::segments()}}--}}
{{--                    {{__($deleted_clients)}}--}}
                    <div class="table-responsive">

                        <table id="deleted_clientsTable" class="table table-sm table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Emri</th>
                                <th>Telefoni</th>
                                <th>Qyteti</th>

                                <th>Shtuar me:</th>

                                <th>Veprimet</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deleted_clients as $client)
                                <tr id="client_{{$client->id}}">
                                    <td>{{$client->name}}</td>
                                    <td>{{$client->phone}}</td>
                                    <td>{{$client->city}}</td>

                                    <td>{{$client->created_at}}</td>
                                    <td>
                                        <div class="btn-group-sm text-center">
                                            <a href="client/{{$client->id}}"
                                               class="font-weight-bold text-uppercase  btn-sm btn-outline-primary">Shiqo</a>
                                            <a href=""
                                               class="font-weight-bold text-uppercase  btn-sm btn-outline-danger"
                                               onclick="event.preventDefault();
                                                       if(confirm('Konfirmo fshirjen e klientit')){
                                                       axios({
                                                       method: 'post',
                                                       url: '/client/'+'{{$client->id}}',
                                                       data: {
                                                       _method: 'DELETE'
                                                       }
                                                       }).then(function () {

                                                       clientsTable.row( $('#client_{{$client->id}}')).remove();
                                                       clientsTable.draw();
                                                       // location.reload();

                                                       })
                                                       .catch(function (error) {
                                                       console.log(error);
                                                       });

                                                       }


                                                       ">Fshij</a>


                                        </div>
                                    </td>

                                </tr>

                            @endforeach


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection