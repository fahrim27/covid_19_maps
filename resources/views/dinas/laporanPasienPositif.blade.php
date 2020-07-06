@extends('admin.app')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Laporan Harian Pasien</h4>
                    </div>
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-4">
                        <div class="d-print-none mo-mt-2">
                            <div class="text-right">
                                        <!-- Small modal -->
                                <input data-id="nama" type="text" autocomplete="off" id="search" class="form-control input-lg search" placeholder="Cari Berdasarkan nama pasien">
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->

            </div>
            
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
            
            <span id="txtHint"></span>
            <!-- end page-title -->
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <div id="table-pasien" class="table-rep-plugin" >
                            <div class="table-responsive b-0" data-pattern="priority-columns">
                            
                            <table id="tech-companies-1" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                   
                                                    <td>{!! $positif->nama !!}<br>
                                                    @if($positif->user_id != NULL)
                                                        <?php $nrp = App\User::select('nrp')->whereId($positif->user_id)->first() ?>
                                                        <span class="badge badge-primary">{{$nrp['nrp']}}</span>
                                                    @endif
                                                    </td>
                                                    </div>
                                                    <?php $dateNow = date("Y-m-d"); $p = App\Penilaian::where('user_id', $positif->user_id)->where('tanggal', $dateNow)->get();?>
                                                    @if($p->count() == 0)
                                                    <td class="text-center" colspan="17"><i>- Pasien belum melakukan login hari ini -</i></td>
                                                    @else
                                                    @foreach($p as $rundown)
                                                        @if($loop->iteration <= 2)
                                                        @if($loop->iteration == 1)                     
                                                            @if($rundown->keterangan == 0 )<span class="badge badge-success">Normal</span>
                                                            @elseif($rundown->keterangan == NULL)<span></span>@else {{$rundown->keterangan}} &#176;@endif</td>
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
                                                        {{-- <a data-id="{{$positif->id}}" class="btn btn-outline-danger detail" data-toggle="modal"><i class="fas fa-pencil-alt" style="color: white;"></i></a> --}}
                                                        <a class="btn btn-outline-info"><i class="fas fa-file-medical" data-target="#add-test-{{$positif->id}}" data-toggle="modal" style="color: white;"></i></a>
                                                      </td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                            
                            </div>
                            </div>
                            {{$pasienPositif->links()}}
                        </div>
                        
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end row -->
    </div>
</div>


@foreach($pasienPositif as $positif)
<div class="modal fade bs-example-modal-center" id="add-test-{{$positif->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true" style="margin-top: -10%;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Riwayat catatan test pasien {{$positif->nama}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <div class="card m-b-30">
                    <div class="card-body">
                            @if(App\Test::where('pasien_id', $positif->id)->count() == 0)
                                <h4 style="font-size: 17px;" class="text-center badge badge-danger">Pasien belum pernah melakukan test rapid maupun swap!</h4>
                            @else
                                        <div id="accordion">
                                            @foreach(App\Test::where('pasien_id', $positif->id)->get() as $test)
                                            <div class="card mb-0">
                                                <div class="card-header" id="heading-{{$test->id}}">
                                                    <h5 class="mb-0 mt-0 font-14">
                                                        @if($test->tgl_hasil_tes == NULL)
                                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                            href="#collapse{{$test->id}}" aria-expanded="false"
                                                            aria-controls="collapse{{$test->id}}">
                                                             <span style="font-size: 15px;" class="text-dark badge badge-warning">{{$test->jenis_tes}}</span>
                                                        </a>
                                                        @else
                                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                            href="#collapse{{$test->id}}" aria-expanded="false"
                                                            aria-controls="collapse{{$test->id}}" >
                                                            <span style="font-size: 15px;" class="text-dark badge badge-success">
                                                             {{$test->jenis_tes}}
                                                            </span>
                                                        </a>
                                                        @endif
                                                    </h5>
                                                </div>
            
                                                <div id="collapse{{$test->id}}" class="collapse"
                                                    aria-labelledby="heading{{$test->id}}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <form class="" action="#" method="">
                                                            <div class="form-group">
                                                                <label>Tanggal Test</label>
                                                                <input type="text" name="tgl_tes" class="form-control border border-light" readonly value="{{$test->tgl_tes}}" placeholder="{{$test->tgl_tes}}" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tanggal Hasil Test</label>
                                                                <input type="text" name="tgl_hasil_tes" class="form-control border border-light" readonly placeholder="{{$test->tgl_hasil_tes}}" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Keterangan Hasil Test</label>
                                                                <textarea name="keterangan" class="form-control border border-light" readonly placeholder="{{$test->keterangan}}"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Foto Hasil Test (opsional)</label>
                                                                @if($test->foto != NULL)
                                                                <img style="text-center" src="{{asset('/hasil_test/'.$test->foto)}}">
                                                                @else
                                                                <p>-</p>
                                                                @endif
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                            @endif
                                    </div>
                                </div>
                                
                            </div>
                            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endforeach

@endsection


@section('scripts')

<script>
    
        $("#search").keyup(function(){
             str =  $("#search").val();
             var filter_by  = $(this).data("id");
             if(str != "") {
                     $.get( "{{ url('admin/get_filtered_by?str=') }}"+str+"&filter_by="+filter_by, function( data ) {
                         $( "#txtHint" ).html( data );  
                  });
            
             }
             else{
                $("#txtHint").empty();
            }
         });
    
        function loadlink(){
            $('#table-pasien').load('/dinas/interval/laporan/pasien/');
            // console.log('TESTING!!!!');
        }
        var sound;
        function playAudio(){
            
            console.log('play warning audio');
            sound = new Audio('{{ asset("sounds/warning.ogg") }}');
            // sound.loop = true;
            
            sound.play();
        }
    
        setInterval(function(){
            <?php
                if(App\Panic::where('status', 0)->exists()){
                    
            ?>
                playAudio()
            <?php } ?>
            
            loadlink()
        }, 30000);



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