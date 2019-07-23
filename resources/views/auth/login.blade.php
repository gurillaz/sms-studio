<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-6 col-md-6">

            <div class="card o-hidden border-0 shadow-lg my-5" style="top: 20vh">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
{{--                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>--}}
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Hej..</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf


                                    <div class="form-group">
{{--                                        <input type="email" class="form-control form-control-user"--}}
{{--                                               id="exampleInputEmail" aria-describedby="emailHelp"--}}
{{--                                               placeholder="Enter Email Address...">--}}

                                        <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror

                                    </div>
                                    <div class="form-group">
{{--                                        <input type="password" class="form-control form-control-user"--}}
{{--                                               id="exampleInputPassword" placeholder="Password">--}}

                                        <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror



                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
{{--                                            <input type="checkbox" class="custom-control-input" id="customCheck">--}}

                                            <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

{{--                                            <label class="custom-control-label" for="customCheck">Remember Me</label>--}}

                                            <label class="custom-control-label" for="remember">
                                                {{ __('Ruaj kyqjen') }}
                                            </label>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-primary btn-user btn-block">{{ __('Kyqu') }}</button>






                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.html">Kam harruar fjalkalimin.</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
