@extends('admin.app')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Data Pasien (Petugas)</h4>
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-2">
                        <div class="d-print-none mo-mt-2">
                            <div class="text-right">
                                        <!-- Small modal -->
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#create">Tambah Data</button>
                            </div>
                        </div>
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
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-rep-plugin">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>NIK</th>
                                                    <th>Nama</th>
                                                    <th>Usia</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Kasus</th>
                                                    <th>Isolasi</th>
                                                    <th>Kelurahan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @php $i=1 @endphp
                                            <tbody id="organisasi_body">
                                                @foreach($getAllPasienbyPetugas as $ps)
                                                <tr id="item{{$ps->id}}">
                                                    <td>{{ $ps->nik }}</td>
                                                    <td>{!! $ps->nama !!}</td>
                                                    <td>{{ $ps->usia }} th</td>
                                                    <td>{{ $ps->jenis_kelamin == 0 ? 'Laki-Laki' : 'Perempuan' }}</td>
                                                    <td>{{ $ps->jenis_kasus->nama }} | {{ $ps->status }}</td>
                                                    <td>{{ $ps->jenis_isolasi == 0 ? 'Mandiri' : $ps->jenis_isolasi == 2 ? 'Delta Maya' : $ps->jenis_isolasi == 3 ? 'Lingkar Timur' : 'Rumah Sakit' }}</td>
                                                    <td>{{$ps->kelurahan->nama}}</td>
                                                    {{-- <td>{{date('j F Y', strtotime ($rs->created_at))}}</td> --}}
                                                    <td>
                                                        <a data-id="{{$ps->id}}" class="btn btn-outline-info detail" data-toggle="modal"><i class="fas fa-fas fa-map-marked-alt" style="color: white;"></i></a>
                                                        @if($ps->jenis_kasus_id == 1)
                                                            @if($ps->user_id != NULL)
                                                                <a href="#user-pasien" data-target="#user-pasien"    class="btn btn-outline-info" data-toggle="modal" ><i class="fas fa-user" style="color: white;"></i></a>
                                                            @else
                                                                <a onclick="event.preventDefault(); document.getElementById('user-pasien-form').submit();" class="btn btn-outline-success" data-toggle="modal" ><i class="fas fa-user-plus" style="color: white;"></i></a>

                                                                <form id="user-pasien-form" action="{{route('admin.user.pasien', $ps->id)}}" method="POST" style="display: none;">
                                                                    @csrf
                                                                </form>
                                                            @endif
                                                        @endif
                                                        <a data-id="{{$ps->id}}" class="btn btn-outline-warning edit" data-toggle="modal" ><i class="fas fa-edit" style="color: white;"></i></a>
                                                        <a data-id="{{$ps->id}}" class="btn btn-outline-danger delete"><i class="fas fa-trash" style="color: white;"></i></a>
                                                      </td>
                                                </tr>

<!-- modal-->
<div class="modal fade bs-example-modal-center" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Data Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="" action="{{route('admin.pasien.update', $ps->id)}}" method="post">
                    @csrf
                    {{method_field('put')}}
                    <div class="form-group">
                        <label>No. Telpon Pasien</label>
                        <input id="nik" type="number" name="nik" class="form-control border border-light" placeholder=" . . . . . . . . . . . " value="{{ request('nik') }}" />
                    </div>
                    <div class="form-group">
                        <label>Nama Pasien</label>
                        <input id="nama" type="text" name="nama" class="form-control border border-light" placeholder=" . . . . . . . . . . . " value="{{ request('nama') }}" />
                    </div>
                    <div class="form-group">
                        <label>Jenis Kasus Pasien</label>
                        <select id="jenis_kasus" name="jenis_kasus" class="form-control select2">
                          <option value="" selected disabled>{{$ps->jenis_kasus->nama}}</option>
                          @foreach($jenis_kasus as $jk)
                          <option value="{{$jk->id}}">{{$jk->nama}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Isolasi Pasien</label>
                        <select id="jenis_isolasi" name="jenis_isolasi" class="form-control select2">
                          <option value="" selected disabled>{{ $ps->jenis_isolasi == 0 ? 'Mandiri' : $ps->jenis_isolasi == 2 ? 'Delta Maya' : $ps->jenis_isolasi == 3 ? 'Lingkar Timur' : 'Rumah Sakit' }}</option>
                          <option value="0">Mandiri</option>
                          <option value="1">Rumah Sakit</option>
                          <option value="2">Delta Mayang</option>
                          <option value="3">Lingkar Timur</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Status Pasien</label>
                        <select id="status" name="status" class="form-control select2">
                          <option value="" selected disabled>{{ $ps->status }}</option>
                          <option value="Dirawat">Dirawat</option>
                          <option value="Meninggal">Meninggal</option>
                          <option value="Sembuh">Sembuh</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Usia Pasien</label>
                        <input id="usia" type="number" name="usia" class="form-control border border-light" placeholder=" . . . . . . . . . . . " value="{{ request('usia') }}" />
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin Pasien</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control select2">
                          <option value="" selected disabled>{{ $ps->jenis_kelamin == 0 ? 'Laki-Laki' : 'Perempuan' }}</option>
                          <option value="0">Laki-Laki</option>
                          <option value="1">Perempuan</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Alamat KTP Pasien</label>
                        <input id="alamat_ktp" type="text" name="alamat_ktp" class="form-control border border-light" placeholder=" . . . . . . . . . . . " value="{{ request('alamat_ktp') }}" />
                    </div>
                    <div class="form-group">
                        <label>Alamat Tinggal Pasien</label>
                        <input id="alamat_sekarang" type="text" name="alamat_sekarang" class="form-control border border-light" placeholder=" . . . . . . . . . . . " value="{{ request('alamat_sekarang') }}" />
                    </div>
                    <div class="form-group">
                        <label>Kecamatan Pasien</label>
                        <select id="kecamatan_id" name="kecamatan_id" class="form-control select2">
                          <option value="" selected disabled>{{$ps->kelurahan->kecamatan->nama}}</option>
                          @foreach($kecamatan as $kc)
                          <option value="{{$kc->id}}">{{$kc->nama}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Kelurahan Pasien ({{ $ps->kelurahan->nama }})</label>
                        <select id="kelurahan_id" name="kelurahan_id" class="form-control select2">
                        </select>
                    </div>
                    <input type="hidden" id="id" name="id" value="{{$ps->id}}">
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

@if(App\User::where('id', $ps->user_id)->exists() && $ps->user_id != NULL)
<div class="modal fade bs-example-modal-center" id="user-pasien" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Data Akses Pengguna Posko</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="user-posko"></span>
                    <div class="form-group">
                        <label>Nama Pengguna</label>
                        <input placeholder="{{$ps->user->nrp}}" id="nrp" readonly type="text" name="nrp" class="form-control border border-light"/>
                    </div>    
                    <div class="form-group">
                        <label>Didaftarkan   Pada</label>
                        <input placeholder="{{$ps->user->created_at}}" readonly type="text" class="form-control border border-light"/>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
@endif

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


<!-- modal-->
<div class="modal fade bs-example-modal-center" id="create" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Tambah Data Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="" action="{{route('admin.pasien.store')}}"  method="post">
                    @csrf
                    <div class="form-group">
                        <label>No. Telpon Pasien</label>
                        <input id="nik" type="number" name="nik" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Nama Pasien</label>
                        <input id="nama" type="text" name="nama" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Jenis Kasus Pasien</label>
                        <select id="jenis_kasus" name="jenis_kasus" class="form-control select2 border border-light">
                          <option value="" selected disabled>Select</option>
                          @foreach($jenis_kasus as $jk)
                          <option value="{{$jk->id}}">{{$jk->nama}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Isolasi Pasien</label>
                        <select id="jenis_isolasi" name="jenis_isolasi" class="form-control select2">
                          <option value="" selected disabled>Select</option>
                          <option value="0">Mandiri</option>
                          <option value="1">Rumah Sakit</option>
                          <option value="2">Delta Maya</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Status Pasien</label>
                        <select id="status" name="status" class="form-control select2">
                          <option value="" selected disabled>Select</option>
                          <option value="Dirawat">Dirawat</option>
                          <option value="Meninggal">Meninggal</option>
                          <option value="Sembuh">Sembuh</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Usia Pasien</label>
                        <input id="usia" type="number" name="usia" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin Pasien</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control select2">
                          <option value="" selected disabled>Select</option>
                          <option value="0">Laki-Laki</option>
                          <option value="1">Perempuan</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Alamat KTP Pasien</label>
                        <input id="alamat_ktp" type="text" name="alamat_ktp" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Alamat Tinggal Pasien</label>
                        <input id="alamat_sekarang" type="text" name="alamat_sekarang" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Kecamatan Pasien</label>
                        <select id="kecamatan_id2" name="kecamatan_id2" class="form-control select2">
                          <option value="" selected disabled>Select</option>
                          @foreach($kecamatan as $kc)
                          <option value="{{$kc->id}}">{{$kc->nama}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Kelurahan Pasien</label>
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

<div class="modal fade bs-example-modal-center" id="show" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Detail Data Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_detail"></span>
                    <div class="form-group">
                        <label>Petugas Input</label>
                        <input id="petugas" readonly type="text" name="petugas" class="form-control border border-light"/>
                    </div>
                    <div class="form-group">
                        <label>No. Telpon Pasien (+)</label>
                        <input id="nik" readonly type="text" name="nik" class="form-control border border-light"/>
                    </div> 
                    <div class="form-group">
                        <label>Alamat KTP Pasien</label>
                        <input id="alamat_ktp" readonly type="text" name="alamat_ktp" class="form-control border border-light"/>
                    </div>
                    <div class="form-group">
                        <label>Alamat Tinggal Pasien</label>
                        <input id="alamat_sekarang" readonly type="text" name="alamat_sekarang" class="form-control border border-light"/>
                    </div>
                    <div class="form-group">
                        <label>Ditambahkan Pada</label>
                        <input id="tanggal" readonly type="text" name="tanggal" class="form-control border border-light"/>
                    </div> <hr>     
                    <a><i class="fas fa-map-marker-alt" id="zoom"><small style="font-size: 11px;"> *Click untuk lihat posisi pada peta</small></i></a>

                                <span id="form_detail"></span>         
                                <div class="map3"></div>
                </form>
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
           url:'pasien/' + id +'/edit',
           dataType:"json",
           success:function(html){
              $('#edit_modal').modal('show');
              $('input#nama').val(html.data.nama);
              $('input#nik').val(html.data.nik);
              $('input#alamat_sekarang').val(html.data.alamat_sekarang);
              $('input#alamat_ktp').val(html.data.alamat_ktp);
              $('input#usia').val(html.data.usia);
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
           url:'pasien/' + id ,
           dataType:"json",
           success:function(html){
              $('#show').modal('show');
              $('input#alamat_ktp').val(html.data.alamat_ktp);
              $('input#petugas').val(html.nama + html.nrp);
              $('input#nik').val(html.data.nik);
              $('input#alamat_sekarang').val(html.data.alamat_sekarang);
              $('input#tanggal').val(moment(html.data.created_at).format('Do MMMM YYYY'));
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
                    url: "{{ url('admin/pasien')}}"+'/'+id,
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
                    var xlat = 0.000220;
                    var theMarker = {};
                    var print = {};

                  mymap.on('click', function(e) {
                  //var c = L.circle([e.latlng.lat,e.latlng.lng], {radius: 15}).addTo(mymap);
                    if (theMarker != undefined) {
                        mymap.removeLayer(theMarker);
                    };

                        console.log(e.latlng.lat,e.latlng.lng);
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