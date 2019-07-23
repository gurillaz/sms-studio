<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Custom fonts for this template-->
{{--    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">--}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Style-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{--    Template Style--}}
{{--    <link href="css/sb-admin-2.min.css" rel="stylesheet">--}}
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    @include('layouts.sidebar')





    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar HORIZONTAL NAVIGATION BAR -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>



                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">



                    <div class="topbar-divider d-none d-sm-block"></div>


                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">

                                <span class="mr-2 d-none d-lg-inline text-gray-600">{{ __('Login') }}</span>
                            </a>
                        </li>


                    @else

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-user-circle fa-2x text-success"></i>

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profili
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"
                                   onclick="event.preventDefault();
                                           if(confirm('Konfirmo daljen')){
                                           $('#logoutForm').submit();
                                           }

                                ">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Dil
                                </a>
                                <form id="logoutForm" action="/logout" method="post" hidden>
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest

                </ul>

            </nav>
            <!-- End of Topbar HORIZONTAL NAVIGATION BAR  -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                     @yield('content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; {{ config('app.name', 'SMS') }} 2019</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>





<script src="{{ asset('js/app.js') }}"></script>




</body>

</html>
