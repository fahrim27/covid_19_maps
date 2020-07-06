@extends('admin.app')

@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end page-title -->

            <div class="row">
                <div class="col-sm-4 col-xl-4">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="icon-profile bg-primary  text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Jumlah Pasien Positif</h5>
                            </div>
                            <?php 
                                $user = Auth::user()->role;

                                if ($user == 5) {
                                    $positif = App\Pasien::where('jenis_isolasi', 2)->where('jenis_kasus_id', 1)->count();
                                }
                                elseif ($user == 6){
                                    $positif = App\Pasien::where('jenis_isolasi', 3)->where('jenis_kasus_id', 1)->count();
                                }

                            ?>
                            <h3 class="mt-4">{{$positif}} Pasien</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 col-xl-4">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="icon-profile bg-primary  text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Jumlah Pasien ODP</h5>
                            </div>
                            <?php 
                                $user = Auth::user()->role;

                                if ($user == 5) {
                                    $odp = App\Pasien::where('jenis_isolasi', 2)->where('jenis_kasus_id', 2)->count();
                                }
                                elseif ($user == 6){
                                    $odp = App\Pasien::where('jenis_isolasi', 3)->where('jenis_kasus_id', 2)->count();
                                }

                            ?>
                            <h3 class="mt-4">{{$odp}} Pasien</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 col-xl-4">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="icon-profile bg-primary  text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Jumlah Pasien PDP</h5>
                            </div>
                            <?php 
                                $user = Auth::user()->role;

                                if ($user == 5) {
                                    $pdp = App\Pasien::where('jenis_isolasi', 2)->where('jenis_kasus_id', 3)->count();
                                }
                                elseif ($user == 6){
                                    $pdp = App\Pasien::where('jenis_isolasi', 3)->where('jenis_kasus_id', 3)->count();
                                }

                            ?>
                            <h3 class="mt-4">{{$pdp}} Pasien</h3>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->                                                    

        </div>
        <!-- container-fluid -->

    </div>
    <!-- content -->


</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection