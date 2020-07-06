
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Borderless - Admin Dashboard</title>

    <!-- begin::global styles -->
    <link rel="stylesheet" href="{{ asset('theme/vendors/bundle.css') }}" type="text/css">
    <!-- end::global styles -->

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="{{ asset('theme/css/app.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('theme/vendors/dataTable/responsive.bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('theme/css/custom.css') }}" type="text/css">
    <!-- end::custom styles -->

    @yield('css')

</head>
<body class="dark">

<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading</span>
</div>
<!-- end::page loader -->

<!-- begin::side menu -->
<div class="side-menu">
    <div class='side-menu-body'>
        <ul>
            <li class="side-menu-divider m-t-0"></li>
            <li>
                <a href="{{route('admin.index')}}">
                    <i class="icon fa fa-globe"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon fa fa-globe"></i>
                    <span>Wilayah</span>
                </a>
                <ul>
                    <li>
                        <a href="{{route('admin.kecamatan.index')}}">Kecamatan</a>
                    </li>
                    <li>
                        <a href="{{route('admin.kelurahan.index')}}">Kelurahan</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{route('admin.jenis_kasus.index')}}">
                    <i class="icon fa fa-globe"></i>
                    <span>Jenis Kasus</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.user.index')}}">
                    <i class="icon fa fa-globe"></i>
                    <span>User</span>
                </a>
            </li>
            <li class="side-menu-divider m-t-10">Elements</li>
            
        </ul>
        <div class="side-menu-status-bars">
            <h6 class="text-uppercase font-size-11 m-b-10">Users Online</h6>
            <ul class="list-inline m-b-20">
                <li class="list-inline-item">
                    <a href="#">
                        <figure class="avatar avatar-state-warning avatar-xs">
                            <img src="{{ asset('theme/media/image/avatar.jpg') }}" class="rounded-circle">
                        </figure>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#">
                        <figure class="avatar avatar-state-success avatar-xs">
                            <span class="avatar-title bg-primary rounded-circle">E</span>
                        </figure>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#">
                        <figure class="avatar avatar-state-success avatar-xs">
                            <span class="avatar-title bg-danger rounded-circle">SC</span>
                        </figure>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#">
                        <figure class="avatar avatar-state-warning avatar-xs">
                            <span class="avatar-title bg-info rounded-circle">A</span>
                        </figure>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#">
                        <figure class="avatar avatar-xs">
                            <span class="avatar-title bg-dark font-size-14 rounded-circle">+5</span>
                        </figure>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- end::side menu -->

<!-- begin::navbar -->
<nav class="navbar">
    <div class="container-fluid">

        <div class="header-logo">
            <a href="#">
                <img class="d-none d-lg-block" src="{{ asset('theme/media/image/white-logo.png') }}" alt="...">
                <img class="d-lg-none d-sm-block" src="{{ asset('theme/media/image/mobile-logo.png') }}" alt="...">
            </a>
        </div>

        <div class="header-body">
            <form class="search">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search ..."
                                   aria-label="Recipient's username"
                                   aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-light" type="button" id="button-addon2">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" data-toggle="dropdown">
                        <i class="fa fa-user-o"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
                        <div class="dropdown-menu-title text-center"
                             data-backround-image="{{ asset('theme/media/image/image1.png') }}">
                            <figure class="avatar avatar-state-success avatar-sm m-b-10 bring-forward">
                                <img src="{{ asset('theme/media/image/avatar.jpg') }}" class="rounded-circle" alt="image">
                            </figure>
                            <h6 class="text-uppercase font-size-12 m-b-0">Nama User</h6>
                        </div>
                        <div class="dropdown-menu-body">
                            <div class="bg-light p-t-b-15 p-l-r-20">
                                <h6 class="text-uppercase font-size-11">Profile completion</h6>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                                <a href="#" class="list-group-item link-2">Profile</a>
                                <a href="#" class="list-group-item link-2 d-flex">Followers <span
                                        class="text-muted ml-auto">214</span></a>
                                <a href="#" class="list-group-item link-2 sidebar-open" data-sidebar-target="#settings">Settings</a>
                                <a href="#" class="list-group-item text-danger">Logout</a>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item d-lg-none d-sm-block">
                    <a href="#" class="nav-link side-menu-open">
                        <i class="ti-menu"></i>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>
<!-- end::navbar -->

<!-- begin::main content -->
<main class="main-content">

    {{-- <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Chartjs</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Charts</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chartjs</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chartjs_one"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chartjs_two"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chartjs_three"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chartjs_four"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chartjs_five"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chartjs_six"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div> --}}


    @yield('content')
</main>
<!-- end::main content -->

<!-- begin::global scripts -->
<script src="{{ asset('theme/vendors/bundle.js') }}"></script>
<!-- end::global scripts -->

<!-- begin::chart -->
{{-- <script src="{{ asset('theme/vendors/charts/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('theme/js/examples/charts/chartjs.js') }}"></script> --}}
<!-- end::chart -->

<script src="{{ asset('theme/vendors/dataTable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/vendors/dataTable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('theme/vendors/dataTable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('theme/js/examples/datatable.js') }}"></script>

<!-- begin::custom scripts -->
<script src="{{ asset('theme/js/custom.js') }}"></script>
<script src="{{ asset('theme/js/borderless.min.js') }}"></script>
<!-- end::custom scripts -->

@yield('script')
</html>