@extends('admin.app')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Data User Posko</h4>
                    </div>
                    <div class="col-sm-4">
                    </div>
                    @can('can_petugas')
                    <div class="col-sm-2">
                        <div class="d-print-none mo-mt-2">
                            <div class="text-right">
                                        <!-- Small modal -->
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#create">Tambah Data</button>
                            </div>
                        </div>
                    </div>
                    @endcan
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
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-rep-plugin">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Nama Pengguna</th>
                                                    <th>Nama Posko</th>
                                                    <th>Kelurahan</th>
                                                    <th>Dibuat Pada</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @php $i=1 @endphp
                                            <tbody id="organisasi_body">
                                                @foreach($getAllPosko as $pk)
                                                <tr id="item{{$pk->id}}">
                                                    <td>{!! $pk->id !!}</td>
                                                    <td>{!! $pk->nama !!}</td>
                                                    <td>{{$pk->kelurahan->nama}}</td>
                                                    <td>{{date('j F Y', strtotime ($pk->created_at))}}</td>
                                                    <td>
                                                        <a data-id="{{$pk->id}}" class="btn btn-outline-info detail" data-toggle="modal"><i class="fas fa-fas fa-map-marked-alt" style="color: white;"></i></a>
                                                        @can('can_petugas')
                                                        <a data-id="{{$pk->id}}" class="btn btn-outline-warning edit" data-toggle="modal" ><i class="fas fa-edit" style="color: white;"></i></a>
                                                        <a data-id="{{$pk->id}}" class="btn btn-outline-danger delete"><i class="fas fa-trash" style="color: white;"></i></a>
                                                        @endcan
                                                      </td>
                                                </tr>

@can('can_petugas')
<!-- modal-->
<div class="modal fade bs-example-modal-center" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Data Posko</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="" action="{{route('admin.posko.update', $pk->id)}}" method="post">
                    @csrf
                    {{method_field('put')}}
                    <div class="form-group">
                        <label>Nama Posko</label>
                        <input id="nama" type="text" name="nama" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Kecamatan Posko</label>
                        <select id="kecamatan_id" name="kecamatan_id" class="form-control select2">
                          <option value="" selected disabled>Select</option>
                          @foreach($kecamatan as $kc)
                          <option value="{{$kc->id}}">{{$kc->nama}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Kelurahan Posko</label>
                        <select id="kelurahan_id" name="kelurahan_id" class="form-control select2">
                        </select>
                    </div>
                    <input type="hidden" id="id" name="id" value="{{$pk->id}}">
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
@endcan

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
{{--                             {{$getAllDesa->links()}} --}}
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
</div>

@can('can_petugas')
<!-- modal-->
<div class="modal fade bs-example-modal-center" id="create" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Tambah Data Posko</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="" action="{{route('admin.posko.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nama Posko</label>
                        <input id="nama" type="text" name="nama" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Kecamatan Posko</label>
                        <select id="kecamatan_id2" name="kecamatan_id2" class="form-control select2">
                          <option value="" selected disabled>Select</option>
                          @foreach($kecamatan as $kc)
                          <option value="{{$kc->id}}">{{$kc->nama}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Kelurahan Posko</label>
                        <select id="kelurahan_id2" name="kelurahan_id2" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="select_kelurahan" type="radio" name="select_kelurahan" value="select_kelurahan"> Input Berdasarkan Lokasi Kelurahan
                    </div>
                    <div class="form-group">
                        <input class="location" type="radio" name="location" value="current_location"> Input Berdasarkan Lokasi Sekarang
                    </div>
                    <div class="map"></div>
                    <div class="form-group">
                        <input class="location" type="radio" name="location" value="selection_location"> Pilih Lokasi Data
                    </div>
                    <div class="map2"></div>
                    <div class="latSearch"></div>
                    <div class="lngSearch"></div>
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
@endcan

<div class="modal fade bs-example-modal-center" id="show" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Detail Posko</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a ><i class="fas fa-map-marker-alt" id="zoom"><small style="font-size: 11px;"> *Click untuk lihat posisi pada peta</small></i></a>

                                <span id="form_detail"></span>         
                                <div class="map3"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection


@section('scripts')

<script>

    $(document).ready(function(){     

         $('#create').click(function () {
            $("#alert_results").alert('close');
            $(".alert").alert('close');
          });

         $('#edit_modal').click(function () {
            $("#alert_results").alert('close');
            $(".alert").alert('close');
          });

         $(document).on('click', '.edit', function(){
          $("#alert_results").alert('close');
          var id = $(this).data('id');
          $('#form_result').html('');
          $.ajax({
           url:'posko/' + id +'/edit',
           dataType:"json",
           success:function(html){
              $('#edit_modal').modal('show');
              $('input#nama').val(html.data.nama);
            $('input#id').val(html.data.id);
           
           }
          })
         });

         $(document).on('click', '.detail', function(){
          $("#alert_results").alert('close');
          $("#mapid3").remove();
          var id = $(this).data('id');
          $('#form_detail').html('');
          $.ajax({
           url:'posko/' + id ,
           dataType:"json",
           success:function(html){
              $('#show').modal('show');
              $('input#nama').val(html.data.nama);
            $('input#id').val(html.data.id);

            $('#zoom').on('click', function() {
                $("#mapid3").remove();
                    $(".map3").append('<div id="mapid3" style="height: 350px; margin_bottom : 1px;"></div>');

                var latval = html.data.lat;
                var lngval = html.data.lng;
                var mymap = {};
                
                var latlng = new L.LatLng(latval, lngval);
                    
                   mymap = L.map('mapid3').setView(latlng, 13)
                            L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                                    maxZoom: 22,
                                    subdomains:['mt0','mt1','mt2','mt3'],
                                    attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
                            }).addTo(mymap);

                  var marker = L.marker(latlng).addTo(mymap);
            });

            }
          })
         });

            $('.delete').click(function () {
                var id = $(this).data("id");
                var obj = $(this);
                if(confirm("Are You sure want to delete !")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/posko')}}"+'/'+id,
                    data:{
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function (data) {
                      html = '<div id="alert_results" class="alert alert-success">' + data.success + '</div>';
                      $(obj).closest('#item' + id).css('background','tomato');
                         $(obj).closest('#item' + id).fadeOut(800,function(){
                              $('#item' + id).remove();
                         });
                         $("#alert_results").alert('close');
                        $('#results').prepend(html);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
              }

            }); 

    });

    $('.location').on('change', function() {
        var filBy = $("input[name='location']:checked").val();

        if(filBy == 'current_location'){

            $("#mapid2").remove();
            $(".map").append('<div id="mapid" style="height: 350px; margin_bottom : 1px;"></div>');

            $(document).ready(function() {
                geoLocationInit();
            });
            function geoLocationInit() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(success, fail);
                } else {
                    alert("Browser not supported");
                }
            }

            function success(position) {
                var latval = position.coords.latitude;
                var lngval = position.coords.longitude;
                var lat = {};
                var lng = {};
                var mymap = {};

                var latlng = new L.LatLng(latval, lngval);
                    console.log(latlng);
                   mymap = L.map('mapid').setView(latlng, 13)
                            L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                                    maxZoom: 22,
                                    subdomains:['mt0','mt1','mt2','mt3'],
                                    attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
                            }).addTo(mymap);

                  var marker = L.marker(latlng).addTo(mymap);

                        lat = $(".latSearch");
                        lng = $(".lngSearch");
                        var append1 = '<input type="hidden" id="latSearch" name="latSearch[]" value="'+position.coords.latitude+'"/>';
                        var append2 = '<input type="hidden" id="lngSearch" name="lngSearch[]" value="'+position.coords.longitude+'"/>';
                            
                            lat.append(append1);
                            lng.append(append2);

                }

            function fail() {
                alert("Browser not supported");
            }
        }
        else if(filBy == 'selection_location') {

            $("#mapid").remove();
            $(".map2").append('<div id="mapid2" style="height: 350px;"></div>');

            $(document).ready(function() {
                geoLocationInit();
            });
            function geoLocationInit() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(success, fail);
                } else {
                    alert("Browser not supported");
                }
            }

            function success(position) {
                var mymap = {};

                    mymap = L.map('mapid2').setView([-7.4478, 112.7183], 13)
                            L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                                    maxZoom: 22,
                                    subdomains:['mt0','mt1','mt2','mt3'],
                                    attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
                            }).addTo(mymap);

                    var xlng = 0.000256;
                    var xlat = 0.000200;
                    var theMarker = {};
                    var lat = {};
                    var lng = {};
                    var print = {};

                  mymap.on('click', function(e) {
                  //var c = L.circle([e.latlng.lat,e.latlng.lng], {radius: 15}).addTo(mymap);
                    if (theMarker != undefined) {
                        mymap.removeLayer(theMarker);
                    };
                        theMarker = L.marker([e.latlng.lat,e.latlng.lng]).addTo(mymap); 

                        lat = $(".latSearch");
                        lng = $(".lngSearch");
                        var append1 = '<input type="hidden" id="latSearch" name="latSearch[]" value="'+e.latlng.lat+'"/>';
                        var append2 = '<input type="hidden" id="lngSearch" name="lngSearch[]" value="'+e.latlng.lng+'"/>';
                            
                            lat.append(append1);
                            lng.append(append2);
                      
                    });

                }

            function fail() {
                alert("Browser not supported");
            }

        }
    });


    // navigator.geolocation.getCurrentPosition(function(location) {
      
    // });

</script>

@endsection