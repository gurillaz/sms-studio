{{--@extends('layouts.app')--}}

{{--@section('sidebar')--}}


<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sticky-top" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-photo-video"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SMS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(request()->routeIs('home*')) active @endif">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Pasqyre</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Heading -->
    <div class="sidebar-heading">
        Menaxhimi
    </div>
    {{--    Clients menu item--}}
    <li class="nav-item @if(request()->routeIs('event*')) active @endif">
        <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseEvents" aria-expanded="true"
           aria-controls="collapseEvents">
            <i class="fas fa-fw fa-calendar-day"></i>
            <span>Rezervimet</span>
        </a>
        <div id="collapseEvents" class="collapse @if(request()->routeIs('event*')) show @endif" aria-labelledby="headingEvents" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menaxho rezervimet</h6>
                <a class="collapse-item " href="/event#add_event_section">Shto rezervim</a>
                <a class="collapse-item" href="/event#events_section">Te gjitha rezervimet</a>
                <a class="collapse-item" href="/client#deleted_events_section">Rezervimet e anuluara</a>
            </div>
        </div>
    </li>
    {{--    Clients menu item--}}
    <li class="nav-item @if(request()->routeIs('client*')) active @endif">
        <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseClients" aria-expanded="true"
           aria-controls="collapseClients">
            <i class="fas fa-fw fa-users"></i>
            <span>Klientet</span>

        </a>
        <div id="collapseClients" class="collapse @if(request()->routeIs('client*')) show @endif" aria-labelledby="headingClients" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded navbar">
                <h6 class="collapse-header">Menaxho klientet</h6>
                <a class="collapse-item" href="/client#clients_section">Te gjithe klientet</a>
                <a class="collapse-item" href="/client#add_client_section">Shto klient</a>
                <a class="collapse-item" href="/client#deleted_clients_section">Klientet e fshire</a>

        </div>
    </li>

    {{--    Offers menu item--}}
    <li class="nav-item @if(request()->routeIs('offer*')) active @endif">
        <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseOffers" aria-expanded="true"
           aria-controls="collapseOffers">
            <i class="fas fa-fw fa-hand-holding-usd"></i>
            <span>Ofertat</span>
        </a>
        <div id="collapseOffers" class="collapse @if(request()->routeIs('event*')) show @endif" aria-labelledby="headingOffers" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menaxho ofertat</h6>
                <a class="collapse-item" href="/offer#add_offer_section">Shto oferte</a>
                <a class="collapse-item" href="/offer#offers_section">Te gjithe ofertat</a>
                <a class="collapse-item" href="/offer#deleted_offer_section">Ofertat pasive</a>
            </div>
        </div>
    </li>


    {{--    Services menu item--}}
    <li class="nav-item  @if(request()->routeIs('service*')) active @endif">
        <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseService" aria-expanded="true"
           aria-controls="collapseService">
            <i class="fas fa-fw fa-photo-video"></i>
            <span>Sherbimet</span>
        </a>
        <div id="collapseService" class="collapse  @if(request()->routeIs('service*')) show @endif" aria-labelledby="headingServices" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menaxho sherbimet</h6>
                <a class="collapse-item" href="/client#add_client_section">Shto sherbim</a>
                <a class="collapse-item" href="/client#clients_section">Te gjitha sherbimet</a>
                <a class="collapse-item" href="/client#deleted_clients_section">Sherbimet pasive</a>
            </div>
        </div>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Studio
    </div>
    <!-- Payyments Collapse Menu -->
    <li class="nav-item @if(request()->routeIs('payment*')) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePeyments"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pagesat</span>
        </a>
        <div id="collapseService" class="collapse  @if(request()->routeIs('payment*')) show @endif" aria-labelledby="headingServices" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menaxho sherbimet</h6>
                <a class="collapse-item" href="/client#add_client_section">Shto sherbim</a>
                <a class="collapse-item" href="/client#clients_section">Te gjitha sherbimet</a>
                <a class="collapse-item" href="/client#deleted_clients_section">Sherbimet pasive</a>
            </div>
        </div>
    </li>

    <!-- Employees Collapse Menu -->
    <li class="nav-item @if(request()->routeIs('employee*')) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
           aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Puntoret</span>
        </a>
        <div id="collapseTwo" class="collapse @if(request()->routeIs('employee*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menaxho puntoret:</h6>
                <a class="collapse-item" href="/employee#employees_section">Te gjithe puntoret</a>
                <a class="collapse-item" href="/employee#add_employee_section">Shto puntor te ri</a>
            </div>
        </div>
    </li>


    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item @if(request()->routeIs('inventory*')) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Pajisjet</span>
        </a>
        <div id="collapseUtilities" class="collapse @if(request()->routeIs('inventory*')) show @endif" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

{{--@endsection--}}