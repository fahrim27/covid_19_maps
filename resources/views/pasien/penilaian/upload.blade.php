@extends('admin.app')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">2. Pelaporan Aktivitas Harian</h4>
                    </div>
                </div> <!-- end row -->

            </div>
            <span id="results"></span>
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('errors'))
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors as $error)
                                        <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
            <!-- end page-title -->
            <div class="row">
              <div class="col-xl-1"></div>
              <div class="col-xl-10">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">Selamat data Pasien {{Auth::user()->nrp}}</h4>
                            <p class="sub-title">Silahkan untuk mengisi rundown kegiatan dengan benar dan tepat wakti.</p>

                            <div id="accordion">
                              @foreach($rundown as $rundwn)
                                <div class="card mb-0">
                                    <div class="card-header" id="heading{{$rundwn->id}}">
                                        <h5 class="mb-0 mt-0 font-14">
                                          @if($rundwn->keterangan != NULL)
                                            <i class="fa fa-check text-success"> </i>
                                          @else
                                            <i class="fa fa-window-close text-danger"> </i>
                                          @endif
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                href="#collapse{{$rundwn->id}}" aria-expanded="false"
                                                aria-controls="collapse{{$rundwn->id}}">
                                                 {{$rundwn->rundown->jam}} | <small class="badge badge-warning"><i class="fas fa-info"></i>silahkan klik disini</small> <br>{!!$rundwn->rundown->keterangan!!}
                                            </a>
                                        </h5>
                                    </div>

                                    <?php 
                                      date_default_timezone_set('Asia/Jakarta');
                                      $timeNow = date('H.i'); // Hasil: 20-01-2017 05:32:15 

                                      $timeRundown = $rundwn->rundown->jam;
                                      $timeex = explode("-",$timeRundown);

                                    ?>

                                    @if($timeNow < $timeex[0])
                                    <div id="collapse{{$rundwn->id}}" class="collapse"
                                            aria-labelledby="heading{{$rundwn->id}}" data-parent="#accordion">
                                        <div class="card-body">
                                          <h4 class="text-center text-warning">Maaf kegiatan anda belum waktunya</h4>
                                        </div>
                                    </div>
                                    @else
                                    @if($rundwn->keterangan == NULL)
                                    <div id="collapse{{$rundwn->id}}" class="collapse"
                                            aria-labelledby="heading{{$rundwn->id}}" data-parent="#accordion">
                                        <div class="card-body">
                                          <form method="post" action="{{route('pasien.penilaian.tahap2', $rundwn->id)}}" class="form-group" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>Keterangan Aktivitas</label>
                                                <input required id="keterangan" type="text" name="keterangan" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                                            </div>
                                            <div class="form-group">
                                                <label>Foto Kegiatan</label>
                                                <input required id="images" type="file" name="images" class="form-control border border-light" capture="camera" accept="image/*"/>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                    Reset
                                                </button>
                                            </div>
                                          </form>
                                        </div>
                                    </div>
                                    @else
                                    <div id="collapse{{$rundwn->id}}" class="collapse"
                                            aria-labelledby="heading{{$rundwn->id}}" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Keterangan Aktivitas</label>
                                                <input readonly value="{{$rundwn->keterangan}}" id="keterangan" type="text" name="keterangan" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                                            </div>
                                            <div class="form-group">
                                                <label>Foto Kegiatan</label>
                                                <input disabled readonly id="foto" type="file" name="foto" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                                            </div>
                                            <div>
                                                <button disabled type="submit" class="btn btn-warning waves-effect waves-light disabled">Laporan Sudah Tersimpan</button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                </div>
                              @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
    </div>
</div>
</div>


@endsection


@section('scripts')
<script></script>
@endsection