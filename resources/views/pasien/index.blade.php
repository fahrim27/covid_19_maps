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
                <div class="col-sm-3 col-xl-3"></div>
                <div class="col-sm-6 col-xl-6">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-calendar-clock bg-success text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Waktu Saat ini</h5>
                            </div>
                            <h3 class="mt-4" id="time"></h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-xl-3"></div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-sm-4 col-xl-4"></div>
                <div class="col-sm-4 col-xl-4">
                    <div class="card">
                        <div class="card-heading p-20">
                            <div>
                                
                                <?php $dateNow = date("Y-m-d"); ?>
                                @if(App\Penilaian::where('tanggal', $dateNow)->where('user_id', Auth::user()->id)->exists())
                                <a href="{{ route('pasien.penilaian2.index') }}"><button class="btn btn-lg btn-block btn-success">Laporan Anda Hari ini Telah Terbuat, <br><small>silahkan klik disini <i class="fa fa-info-circle"></i></small></button></a>
                                @else
                                <button onclick="event.preventDefault(); document.getElementById('make-assesment').submit();" class="btn btn-lg btn-block btn-success">Buat Laporan Anda Sekarang</button>
                                @endif

                                    <form id="make-assesment" action="{{ route('pasien.laporan.store') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xl-4"></div>
            </div>                                                    

        </div>
        <!-- container-fluid -->

    </div>
    <!-- content -->


</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection

@section('scripts')
    
    <script type="text/javascript">
        
        var timeDisplay = document.getElementById("time");


        function refreshTime() {
          var dateString = new Date().toLocaleString("id-ID")
          var formattedString = dateString.replace(", ", " - ");
          timeDisplay.innerHTML = formattedString;
        }

        setInterval(refreshTime, 1000);

    </script>

@endsection