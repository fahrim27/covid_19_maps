@extends('admin.app')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Data Physical Distancing</h4>
                    </div>
                    <div class="col-sm-4">
                    </div>
                    @can('can_petugas')
                    <div class="col-sm-2">
                        <div class="d-print-none mo-mt-2">
                            <div class="text-right">
                                        <!-- Small modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">Tambah Data</button>
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
                                                    <th>Nama</th>
                                                    <th>Keterangan</th>
                                                    <th>Kelurahan</th>
                                                    <th>Dibuat Pada</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @php $i=1 @endphp
                                            <tbody id="organisasi_body">
                                                @foreach($getAllDistance as $ds)
                                                <tr id="item{{$ds->id}}">
                                                    <td>{!! $ds->id !!}</td>
                                                    <td>{!! $ds->nama !!}</td>
                                                    <td>{!! str_limit($ds->keterangan, 40) !!}</td>
                                                    <td>{{$ds->kelurahan->nama}}</td>
                                                    <td>{{date('j F Y', strtotime ($ds->created_at))}}</td>
                                                    <td>
                                                        <a data-id="{{$ds->id}}" class="btn btn-outline-info detail" data-toggle="modal"><i class="fas fa-fas fa-map-marked-alt" style="color: white;"></i></a>
                                                        @can('can_petugas')
                                                        <a data-id="{{$ds->id}}" class="btn btn-outline-warning edit" data-toggle="modal" ><i class="fas fa-edit" style="color: white;"></i></a>
                                                        <a data-id="{{$ds->id}}" class="btn btn-outline-danger delete" style="color: white;"><i class="fas fa-trash"></i></a>
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
                <h5 class="modal-title mt-0">Edit Data Physical Distancing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="" action="{{route('admin.distance.update', $ds->id)}}" method="post">
                    @csrf
                    {{method_field('put')}}
                    <div class="form-group">
                        <label>Nama Physical Distancing</label>
                        <input id="nama" type="text" name="nama" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Keterangan Physical Distancing</label>
                        <input id="keterangan" type="text" name="keterangan" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Kecamatan Physical Distancing</label>
                        <select id="kecamatan_id" name="kecamatan_id" class="form-control select2">
                          <option value="" selected disabled>Select</option>
                          @foreach($kecamatan as $kc)
                          <option value="{{$kc->id}}">{{$kc->nama}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Kelurahan Physical Distancing</label>
                        <select id="kelurahan_id" name="kelurahan_id" class="form-control select2">
                        </select>
                    </div>
                    <input type="hidden" id="id" name="id" value="{{$ds->id}}">
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
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Tambah Data Physical Distancing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="" action="{{route('admin.distance.store')}}"  method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nama Physical Distancing</label>
                        <input type="text" name="nama" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Keterangan Physical Distancing</label>
                        <input type="text" name="keterangan" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Kecamatan Physical Distancing</label>
                        <select id="kecamatan_id2" name="kecamatan_id2" class="form-control select2">
                          <option value="" selected disabled>Select</option>
                          @foreach($kecamatan as $kc)
                          <option value="{{$kc->id}}">{{$kc->nama}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Kelurahan Physical Distancing</label>
                        <select id="kelurahan_id2" name="kelurahan_id2" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="location" type="radio" name="location" value="multiple"> Gambar Garis Physical Distancing
                    </div>
                    <div class="map2"></div>
                    <div class="poly"></div>
                    <div class="form-group">
                        <div>
                            <button name="action" value="Add" type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                            <button id="resetmap" type="reset" class="btn btn-secondary waves-effect m-l-5">
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
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Detail Data Physical Distancing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <label>Keterangan Physical Distancing</label>
                        <input id="keterangan" readonly type="text" name="keterangan" class="form-control border border-light"/>
                    </div> <hr>
                <a><i class="fas fa-map-marker-alt" id="zoom"><small style="font-size: 11px;"> *Click untuk lihat posisi pada peta</small></i></a>

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
           url:'distance/' + id +'/edit',
           dataType:"json",
           success:function(html){
              $('#edit_modal').modal('show');
              $('input#nama').val(html.data.nama);
              $('input#keterangan').val(html.data.keterangan);
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
           url:'distance/' + id ,
           dataType:"json",
           success:function(html){
              $('#show').modal('show');
              $('input#keterangan').val(html.data.keterangan);
                $('input#id').val(html.data.id);

            $('#zoom').on('click', function() {
                $("#mapid3").remove();
                    $(".map3").append('<div id="mapid3" style="height: 450px; margin_bottom : 1px;"></div>');

                var map = L.map('mapid3').setView(html.distance[0], 12);
                var polyline = L.polyline(html.distance, {color: 'red', weight: 4, fill:1,opacity: 0.7,smoothFactor: 1, fillColor: '#e36b6b', fillOpacity: 0.2}).addTo(map);

                L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3'],
                    attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
                }).addTo(map);

                map.fitBounds(polyline.getBounds());
   
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
                    url: "{{ url('admin/distance')}}"+'/'+id,
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

        if(filBy == 'multiple') {
            $(".map2").append('<div id="mapid2" style="height: 450px; margin_bottom : 1px;"></div>');

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
                var latlng = new L.LatLng(latval, lngval);

                    map = L.map('mapid2').setView(latlng, 15)
                        satelit =  L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                                    maxZoom: 22,
                                    subdomains:['mt0','mt1','mt2','mt3'],
                                    attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
                            });

                          drawnItems = L.featureGroup().addTo(map);

                          L.control.layers({
                                'satelit': satelit.addTo(map),
                                "osm": L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
                                    maxZoom: 20,
                                    attribution:'&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                })
                            }, { 'drawlayer': drawnItems }, { position: 'topleft', collapsed: false }).addTo(map);            

                map.addControl(new L.Control.Draw({
                    draw: {
                        polyline: {
                            allowIntersection: false,
                            showArea: true
                        },
                        marker: false,
                        polygon: false,
                        rectangle: false,
                        circle: false
                    }
                }));

                map.on(L.Draw.Event.CREATED, function (e) {
                        drawnItems.addLayer(e.layer);
                        var points = e.layer.getLatLngs();
                      puncte1=points.join(',');
                      puncte1=puncte1.toString();
                      //puncte1 = puncte1.replace(/[{}]/g, '');
                      puncte1=points.join(',').match(/([\d\.]+)/g).join(',')
                    //this is the field where u want to add the coordinates
                    
                     var poly = $(".poly").append('<input type="hidden" id="poly" name="poly[]" value="'+puncte1+'"/>');

                    //console.log(layer.getLatLngs());
                });

            }

            function fail() {
                    alert("Browser not supported");
                }
        }
    }); 

        $('#resetmap').click(function () {
            $("#poly").remove();
            $("#mapid2").remove();
          });

    // navigator.geolocation.getCurrentPosition(function(location) {
      
    // });

</script>

@endsection