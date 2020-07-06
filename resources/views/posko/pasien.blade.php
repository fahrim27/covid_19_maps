@extends('admin.app')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <ul class="nav nav-tabs" style="padding-top:24px;" role="tablist">
                <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">
                                                    <span class="d-none d-md-block">Rundown</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#home" role="tab">
                                                    <span class="d-none d-md-block">Data Semua Pasien</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span> 
                                                </a>
                                            </li>
                                            
                                        </ul>
        
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane p-3" id="home" role="tabpanel">
                                                
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
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive b-0">
                                        <table id="table-pasien" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Nama Pasien</th>
                                                    <th>Skor</th>
                                                    <th>Suhu</th>
                                                    <th>1</th>
                                                    <th>2</th>
                                                    <th>3</th>
                                                    <th>4</th>
                                                    <th>5</th>
                                                    <th>6</th>
                                                    <th>7</th>
                                                    <th>8</th>
                                                    <th>9</th>
                                                    <th>10</th>
                                                    <th>11</th>
                                                    <th>12</th>
                                                    <th>13</th>
                                                    <th>14</th>
                                                    <th>15</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @php $i=1 @endphp
                                            <tbody id="organisasi_body">
                                                @foreach($pasienPositif as $positif)
                                                <tr id="item{{$positif->id}}">
                                                    <td>{!! $positif->nama !!}<br><span class="badge badge-primary">{{ App\User::whereId($positif->user_id)->first()->nrp}}</span></td>
                                                    <?php $dateNow = date("Y-m-d"); $p = App\Penilaian::where('user_id', $positif->user_id)->where('tanggal', $dateNow)->get();?>
                                                    @if($p->count() == 0)
                                                    <td class="text-center" colspan="17"><i>- Pasien belum melakukan login hari ini -</i></td>
                                                    @else
                                                    @foreach($p as $rundown)
                                                        @if($loop->iteration <= 2)
                                                                                                                    <td class="text-center">
                                                                              @if($loop->iteration == 1)                                          @if($rundown->keterangan == 0 )<span class="badge badge-success">Normal</span>
                                                                                                                        @elseif($rundown->keterangan > 0 && $rundown->keterangan <= 2)<span class="badge badge-warning">Waspada</span>
                                                            @elseif($rundown->keterangan == NULL)                           <span></span>                             
                                                                                                                    @else<span class="badge badge-danger">Periksa Diri</span>
                                                                                                                        @endif
                                                                 @else                                                 {{$rundown->keterangan}} &#176;@endif</td>
                                                        @else
                                                            <?php $jamNow = date('H.i');
                                                                $jamRundown = explode('-', $rundown->rundown->jam);
                                                            ?>
                                                            
                                                            @if($rundown->status == 0)
                                                            <td class="text-center"><i class="fas fa-sad-tear text-warning" style="font-size: 16px;"></i></td>
                                                            @elseif($rundown->status == 0 && $jamNow > $jamRundown[1]  )
                                                            <td class="text-center"><i class="fas fa-sad-tear text-danger" style="font-size: 16px;"></i></td>
                                                            @else
                                                            <td class="text-center"><a href="#detail-{{$rundown->id}}" data-target="#detail-{{$rundown->id}}" data-toggle="modal"><i class="fas fa-smile-beam text-success" style="font-size: 16px;"></i></a></td>
                                                            
<div class="modal fade bs-example-modal-center" id="detail-{{$rundown->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Detail Assesment {{$rundown->rundown->jam}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_detail"></span>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input value="{{$rundown->keterangan}}" readonly type="text" name="keterangan" readonly class="form-control border border-light"/>
                    </div>    
                    <div class="form-group">
                        <label>Foto</label>
                        <div class="text-center">
                            <img src="{{asset('laporan/penilaian/'.$rundown->foto)}}">
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

                                                            
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    @endif
                                                    {{-- <td>{{date('j F Y', strtotime ($rs->created_at))}}</td> --}}
                                                    <td>
                                                        @if($positif->nik == NULL)
                                                        <a href="#" class="btn btn-outline-danger"><i class="fab fa-whatsapp" style="color: white;"></i></a>
                                                        @else
                                                        <a href="whatsapp://send?phone={{$positif->nik}}" class="btn btn-outline-success"><i class="fab fa-whatsapp" style="color: white;"></i></a>
                                                        @endif
                                                        <a class="btn btn-outline-info"><i class="fas fa-user-plus" data-target="#add-wa" data-toggle="modal" style="color: white;"></i></a>
                                                        {{-- <a data-id="{{$positif->id}}" class="btn btn-outline-danger detail" data-toggle="modal"><i class="fas fa-pencil-alt" style="color: white;"></i></a> --}}
                                                      </td>
                                                     
                                                </tr>

<div class="modal fade bs-example-modal-center" id="add-wa" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Tambah Atau ubah wa Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('posko.pasien.wa', $positif->id)}}" method="post">
                    @csrf
                    {{method_field('put')}}
                <span id="form_detail"></span>
                    <div class="form-group">
                        <label>Nomor Wa</label>
                        <div class="form-control">
                            <span class="text-white" style="font-size=40px;">+ </span><input type="text" name="wa" placeholder="{{$positif->nik}}" value="{{$positif->nik}}" class="border border-light"/>
                        </div>
                        
                    </div>    
                    <div class="form-group">
                        <div>
                            <button name="action" id="action" value="Add" type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


                                                @endforeach
                                            </tbody>
                                            <input type="button" id="btn-update" style="display: none;">
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                                            </div>
                                            <div class="tab-pane active p-3" id="profile" role="tabpanel">
                                                <div class="card m-b-30">
                                                <div class="card-body">
                                                    <div class="table-rep-plugin">
                                                        <div class="table-rep-plugin">
                                                                <table id="table-pasien" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Waktu</th>
                                                                            <th>Keterangan</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach(App\Rundown::get() as $r)
                                                                            @if($loop->iteration > 2)
                                                                            <tr>
                                                                                <td class="text-center">{{ $loop->iteration-2 }}</td>
                                                                                <td class="text-center" width="128px">{{ $r->jam }}</td>
                                                                                <td >{!! $r->keterangan !!}</td>
                                                                            </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
</div>

@endsection


@section('scripts')

<script>

    function loadlink(){
        $('#table-pasien').load('/posko/ajax/pasien');
        // console.log('TESTING!!!!');
    }
    var sound;
    function playAudio(){
        
        console.log('play warning audio');
        sound = new Audio('{{ asset("sounds/warning.ogg") }}');
        // sound.loop = true;
        
        sound.play();
    }

    loadlink();
    setInterval(function(){
        <?php
            $posko_id = DB::table('posko_user')->where('user_id', Auth::user()->id)->first();
            $posko = App\Posko::where('id', $posko_id->posko_id)->first();
            if(App\Panic::where('kelurahan_id', $posko->kelurahan_id)->where('status', 0)->exists()){
                
        ?>
            playAudio()
        <?php } ?>
        
        loadlink()
    }, 10000);



    // $(document).ready(function(){     

    //      $(document).on('click', '.detail', function(){
    //       $("#alert_results").alert('close');
    //       $("#mapid3").remove();
    //       var id = $(this).data('id');
    //       $('#form_detail').html('');
    //       $.ajax({
    //        url: "{{ url('admin/pasien')}}"+'/'+id,
    //        dataType:"json",
    //        success:function(html){
    //           $('#show').modal('show');
    //           $('input#alamat_ktp').val(html.data.alamat_ktp);
    //           $('input#petugas').val(html.nama + html.nrp);
    //           $('input#alamat_sekarang').val(html.data.alamat_ktp);
    //           $('input#tanggal').val(moment(html.data.created_at).format('Do MMMM YYYY'));
    //         $('input#id').val(html.data.id);

    //         $('#zoom').on('click', function() {
    //             $("#mapid3").remove();
    //                 $(".map3").append('<div id="mapid3" style="height: 350px; margin_bottom : 1px;"></div>');

    //             var latval = html.data.lat;
    //             var lngval = html.data.lng;
    //             var mymap = {};
                
    //             var latlng = new L.LatLng(latval, lngval);
                    
    //                mymap = L.map('mapid3').setView(latlng, 13)
    //                         L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    //                                 maxZoom: 22,
    //                                 subdomains:['mt0','mt1','mt2','mt3'],
    //                                 attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
    //                         }).addTo(mymap);

    //               var marker = L.marker(latlng).addTo(mymap);
    //          });

    //         }
    //       })
    //      });

    // });

    // navigator.geolocation.getCurrentPosition(function(location) {
      
    // });

</script>

@endsection