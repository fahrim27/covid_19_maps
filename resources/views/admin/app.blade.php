<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from themesdesign.in/stexo/layouts/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 16 Feb 2020 11:24:12 GMT -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Admin Kawal Covid-19 Polresta Sidoarjo</title>
    <meta content="Admin Kawal Covid-19 Polresta Sidoarjo" name="description" />
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon">

    @yield('css')
    @stack('styles')

    
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    
    <link href="{{ asset ('theme/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset ('theme/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset ('theme/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset ('theme/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset ('theme/plugins/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('theme/plugins/sweet-alert2/sweetalert2.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link href="{{ asset ('theme/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset ('theme/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('theme/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

    {{-- <script src="https://d3js.org/d3.v3.min.js"></script>
    <script src="https://d3js.org/topojson.v0.min.js"></script> --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <script  src="https://unpkg.com/leaflet@1.0.3/dist/leaflet-src.js"></script>
   <script src="https://unpkg.com/esri-leaflet@2.0.7"></script>
    <script src="https://unpkg.com/esri-leaflet@2.0.7"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>

    <style type="text/css">
        .select2{
            min-width: 100%;
            height: 33px;
        }

        pre {
            min-width:300px;
            white-space: pre-wrap;     
            white-space: -moz-pre-wrap;
            white-space: -pre-wrap;    
            white-space: -o-pre-wrap;  
            word-wrap: break-word;     
        }

        .leaflet-popup-content-wrapper {
            min-width: 350px;
        }
    </style>

</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Top Bar Start -->
        <div class="topbar">

            <!-- LOGO -->
            <div class="topbar-left">
                <a href="#" class="logo">
                    <span class="logo-light">
                            <i class=""></i> Delta Siaga Covid-19
                        </span>
                    <span class="logo-sm">
                            KTS<!--<i class="mdi mdi-comment-search-outline"></i>-->
                        </span>
                </a>
            </div>

            <nav class="navbar-custom">
                <ul class="navbar-right list-inline float-right mb-0">

                    <li class=" notification-list list-inline-item d-none d-md-inline-block">
                        <span>Selamat datang, <strong>{{Auth::user()->name}}</strong></span>
                    </li>

                    <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                        <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                            <i class="mdi mdi-arrow-expand-all noti-icon"></i>
                        </a>
                    </li>

                    <li class="dropdown notification-list list-inline-item">
                        <div class="dropdown notification-list nav-pro-img">
                            <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset ('theme/images/users/avatar0.jpg')}} " alt="user" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                               {{-- <a class="dropdown-item d-block" href="#"><i class="mdi mdi-settings"></i> Settings</a> --}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger"  href="#logout" onclick="$('#logout').submit();"><i class="mdi mdi-power text-danger"></i> Logout</a>
                                <form action="{{route('logout')}}" id="logout" style="display: none;" method="post">
                                    @csrf
                                    <button type="submit">logout</button>
                                </form>
                            </div>
                        </div>
                    </li>

                </ul>

                <ul class="list-inline menu-left mb-0">
                    <li class="float-left">
                        <button class="button-menu-mobile open-left waves-effect">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
                </ul>

            </nav>

        </div>
        <!-- Top Bar End -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.sidebar')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
     
            @yield('content')
      
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->
    <footer class="footer">
        © 2020 Kawal Covid-19 POLRESTA SIDOARJO
    </footer>


    <!-- jQuery  -->
    <script src="{{ asset ('theme/js/jquery.min.js') }}"></script>
    <script src="{{ asset ('theme/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset ('theme/js/metismenu.min.js') }}"></script>
    <script src="{{ asset ('theme/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset ('theme/js/waves.min.js') }}"></script>

    {{-- <script src="{{ asset ('pages/dashboard.init.js') }}"></script> --}}
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

    <script src="{{ asset('theme/plugins/js/rwd-table.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset ('theme/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{--     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="{{ asset('theme/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

    <script src="{{ asset('theme/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('theme/pages/datatables.init.js') }}"></script>
    <!-- Required datatable js -->
    @include('sweet::alert')

    <script type="text/javascript">
         $(document).ready(function() {
            $('.select2').select2();
        });
     </script>

     @yield('scripts')

     <script>
        $(function() {
            $('.table-responsive').responsiveTable({
                addDisplayAllBtn: 'btn btn-secondary'
            });
        });

        $('#kecamatan_id').change(function(){
            var kecID = $(this).val();    
            if(kecID){
                $.ajax({
                   type:"GET",
                   url:"{{url('admin/get-kelurahan-list')}}?kecamatan_id="+kecID,
                   success:function(res){               
                    if(res){
                        $("#kelurahan_id").empty();
                        $("#kelurahan_id").append('<option>Select</option>');
                        $.each(res,function(key,value){
                            $("#kelurahan_id").append('<option value="'+key+'">'+value+'</option>');
                        });
                   
                    }else{
                       $("#kelurahan_id").empty();
                    }
                   }
                });
            }else{
                $("#kelurahan_id").empty();
            }      
           });

        $('#kecamatan_id2').change(function(){
            var kecID = $(this).val();    
            if(kecID){
                $.ajax({
                   type:"GET",
                   url:"{{url('admin/get-kelurahan-list')}}?kecamatan_id="+kecID,
                   success:function(res){               
                    if(res){
                        $("#kelurahan_id2").empty();
                        $("#kelurahan_id2").append('<option>Select</option>');
                        $.each(res,function(key,value){
                            $("#kelurahan_id2").append('<option value="'+key+'">'+value+'</option>');
                        });
                   
                    }else{
                       $("#kelurahan_id2").empty();
                    }
                   }
                });
            }else{
                $("#kelurahan_id2").empty();
            }      
           });
    </script>
    
    <script>
        $('#form-panic').on('submit', function(e){
            var form = this;
            e.preventDefault();
            swal({
              title: 'Apakah Anda Yakin ?',
              text: "Klik Kirim untuk melaporkan urgensi ke posko terdekat !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Kirim'
            }).then((result) => {
              if (result.value) {
                return form.submit();
              }
            })
        });
    </script>
</body>


<!-- Mirrored from themesdesign.in/stexo/layouts/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 16 Feb 2020 11:24:35 GMT -->
</html>