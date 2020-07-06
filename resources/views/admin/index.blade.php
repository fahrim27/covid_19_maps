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
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="fas fa-users bg-primary  text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Jumlah Pasien</h5>
                            </div>
                            <h6 class="mt-4">Positif : {{App\Pasien::get()->where('jenis_kasus_id', 1)->where('status', 'Dirawat')->count()}}<br>ODP : {{App\Pasien::get()->where('jenis_kasus_id', 2)->where('status', 'Dirawat')->count()}} <br> PDP : {{App\Pasien::get()->where('jenis_kasus_id', 3)->where('status', 'Dirawat')->count()}}<br>Sembuh : {{App\Pasien::get()->where('status', 'Sembuh')->count()}} <br>Meninggal : {{App\Pasien::get()->where('status', 'Meninggal')->count()}}<br>Total : {{App\Pasien::get()->count()}}</h6>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="fas fa-campground bg-success text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Jumlah Posko</h5>
                            </div>
                            <h3 class="mt-4">{{App\Posko::get()->count()}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="fas fa-hospital bg-danger text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Jumlah RS</h5>
                            </div>
                            <h3 class="mt-4">{{App\RumahSakit::get()->count()}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="fas fa-user-injured bg-warning text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Jumlah Isolasi</h5>
                            </div>
                            <h6 class="mt-4">{{App\Pasien::where('jenis_isolasi', 0)->get()->count()}} Mandiri</h4>
                            <h6 class="mt-4">{{App\Pasien::where('jenis_isolasi', 1)->get()->count()}} RS</h4>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->                                                    
            
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">Data Pasien Per Kecamatan</h4>

                            <div class="table-rep-plugin">
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="tech-companies-1" class="table  table-striped">
                                        <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Kecamatan</th>
                                            <th>Total</th>
                                            <th data-priority="5">Sembuh</th>
                                            <th data-priority="6">Meninggal</th>
                                            <th data-priority="1">Positif</th>
                                            <th data-priority="2">ODP</th>
                                            <th data-priority="3">PDP</th>
                                            <th data-priority="4">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $x = 1 @endphp
                                        @foreach(App\Kecamatan::get() as $kecamatan)
                                        <tr>
                                            <?php 
                                                $positif = 0;
                                                $odp = 0;
                                                $pdp = 0;
                                                $meninggal = 0;
                                                $sembuh = 0;
                                                foreach($kecamatan->kelurahan as $kelurahan)
                                                    {
                                                        $kelurahan_id = $kelurahan->id;
                                                        
                                                        $pasien_positif = App\Pasien::where('jenis_kasus_id', 1)
                                                                          ->where('kelurahan_id', $kelurahan_id)->where('status', 'Dirawat')->count();
                                                        $pasien_odp = App\Pasien::where('jenis_kasus_id', 2)
                                                                          ->where('kelurahan_id', $kelurahan_id)->where('status', 'Dirawat')->count();
                                                        $pasien_pdp = App\Pasien::where('jenis_kasus_id', 3)
                                                                          ->where('kelurahan_id', $kelurahan_id)->where('status', 'Dirawat')->count();
                                                        $pasien_sembuh = App\Pasien::where('kelurahan_id', $kelurahan_id)->where('status', 'Sembuh')->count();
                                                        $pasien_meninggal = App\Pasien::where('kelurahan_id', $kelurahan_id)->where('status', 'Meninggal')->count();
                                                                          
                                                        $positif += $pasien_positif;
                                                        $odp += $pasien_odp;
                                                        $pdp += $pasien_pdp;
                                                        $meninggal += $pasien_meninggal;
                                                        $sembuh += $pasien_sembuh;
                                                    }
                                                    
                                            ?>
                                            <th>{{$x++}}</th>
                                            <th>{{$kecamatan->nama}}</th>
                                            <th>{{$positif + $odp + $pdp + $sembuh + $meninggal}} Orang</th>
                                            <th>{{$sembuh}} Orang</th>
                                            <th>{{$meninggal}} Orang</th>
                                            
                                            <td>{{$positif}} Orang</td>
                                            <td>{{$odp}} Orang</td>
                                            <td>{{$pdp}} Orang</td>
                                            <td>
                                                <a title="lihat data per-kelurahan" class="btn btn-outline-info" data-target="#kelurahan-{{$kecamatan->id}}" href="#kelurahan-{{$kecamatan->id}}" data-toggle="modal" ><i class="mdi mdi-details" style="color: white;"></i></a>
                                                <a title="print data pasien kecamatan {{$kecamatan->nama}}" class="btn btn-outline-success" href="{{route('admin.print.pdf_pasien.kecamatan', $kecamatan->id)}}"><i class="fas fa-print" style="color: white;"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            
        </div>
        <!-- container-fluid -->

    </div>
    <!-- content -->

@foreach(App\Kecamatan::get() as $kecamatan)
<div class="modal fade bs-example-modal-center" id="kelurahan-{{$kecamatan->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Data Pasine Per Kelurahan ( {{$kecamatan->nama}} )</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
    
                                <div class="table-rep-plugin">
                                    <div class="table-responsive b-0" data-pattern="priority-columns">
                                        <table id="tech-companies-1" class="table  table-striped">
                                            <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Kelurahan</th>
                                                <th>Total</th>
                                                <th data-priority="4">Sembuh</th>
                                                <th data-priority="5">Meninggal</th>
                                                <th data-priority="1">Positif</th>
                                                <th data-priority="2">ODP</th>
                                                <th data-priority="3">PDP</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $x = 1 @endphp
                                            @foreach($kecamatan->kelurahan as $kelurahan)
                                            <tr>
                                                <td>{{$x++}}</td>
                                                <td>{{$kelurahan->nama}}</td>
                                                <td>{{$kelurahan->pasien->count()}}</td>
                                                <td>{{$kelurahan->pasien->where('status', 'Sembuh')->count()}} Orang</td>
                                                <td>{{$kelurahan->pasien->where('status', 'Meninggal')->count()}} Orang</td>
                                                <td>{{$kelurahan->pasien->where('jenis_kasus_id', 1)->where('status', 'Dirawat')->count()}} Orang</td>
                                                <td>{{$kelurahan->pasien->where('jenis_kasus_id', 2)->where('status', 'Dirawat')->count()}} Orang</td>
                                                <td>{{$kelurahan->pasien->where('jenis_kasus_id', 3)->where('status', 'Dirawat')->count()}} Orang</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
    
                                </div>
    
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endforeach

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection