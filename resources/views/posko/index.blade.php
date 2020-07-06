@extends('admin.app')

@section('css')
            <style>
                #peta-persebaran {
                height: 450px;
                font: 10pt "Helvetica Neue", Arial, Helvetica, sans-serif;
                width: 100%;
            }
            @-webkit-keyframes pulse {
  0% {
    -webkit-transform: scale(1);
  }
  50% {
    -webkit-transform: scale(1.1);
  }
  100% {
    -webkit-transform: scale(1);
  }
}

@keyframes  pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}

.location-pin img {
  width: 24px;
  height: 24px;
  margin: -26px 0 0 -13px;
  z-index: 10;
  position: absolute;
  border-radius: 50%;
  animation: pulse 1s infinite;
}
            </style>
@endsection

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
                <div class="col-sm-3 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="icon-profile bg-primary  text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Pasien Positif</h5>
                            </div>
                            <?php 
                                $user = Auth::user()->nrp;

                                $idPosko = explode("-", $user);
                                $kelurahan_id = App\Posko::select('kelurahan_id')->where('id', $idPosko[1])->first()->kelurahan_id;
                                $kelurahan = App\Kelurahan::where('id', $kelurahan_id)->first();
                                $kecamatan = App\Kecamatan::where('id', $kelurahan->kecamatan_id)->first();
                            ?>
                            <h5 class="mt-4">{{App\Pasien::where('kelurahan_id', $kelurahan_id)->where('jenis_kasus_id', 1)->count()}} Pasien</h5>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-3 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-account-group bg-success text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Pasien ODP</h5>
                            </div>
                            <h5 class="mt-4">{{App\Pasien::where('kelurahan_id', $kelurahan_id)->where('jenis_kasus_id', 2)->count()}} Pasien</h5>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-3 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-account-group bg-success text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Pasien PDP</h5>
                            </div>
                            <h5 class="mt-4">{{App\Pasien::where('kelurahan_id', $kelurahan_id)->where('jenis_kasus_id', 3)->count()}} Pasien</h5>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-account-group bg-success text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Nama Posko</h5>
                            </div>
                            <h5 class="mt-4">Kelurahan {{App\Kelurahan::select('nama')->where('id', $kelurahan_id)->first()->nama}}</h5>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->   
            <div class="row">
                <div class="col-12">
                    <div id="peta-persebaran" class="sidebar-map"></div>
                </div>
            </div> <br>
            
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-rep-plugin">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No. Telp</th>
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
                                                @foreach(App\Pasien::where('kelurahan_id', $kelurahan_id)->get() as $ps)
                                                <tr id="item{{$ps->id}}">
                                                    @if($ps->nik == NULL)
                                                        <td>-</td>
                                                    @else
                                                        <td>+{{ $ps->nik }}</td>
                                                    @endif
                                                    <td>{!! $ps->nama !!}</td>
                                                    <td>{{ $ps->usia }} th</td>
                                                    <td>{{ $ps->jenis_kelamin == 0 ? 'Laki-Laki' : 'Perempuan' }}</td>
                                                    <td>{{ $ps->jenis_kasus->nama }}</td>
                                                    <td>{{ $ps->jenis_isolasi == 0 ? 'Mandiri' : 'Rumah Sakit' }}</td>
                                                    <td>{{$ps->kelurahan->nama}}</td>
                                                    {{-- <td>{{date('j F Y', strtotime ($rs->created_at))}}</td> --}}
                                                    <td>
                                                        <a data-id="{{$ps->id}}" class="btn btn-outline-info detail" data-toggle="modal"><i class="fas fa-fas fa-map-marked-alt" style="color: white;"></i></a>
                                                      </td>
                                                </tr>



                                                @endforeach
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- container-fluid -->

    </div>
    <!-- content -->

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

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js"></script>
    <script>
        var basemaps={
            "Google Satelite":L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
                    // maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3'],
                    attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
            }),
            "Esri World Dark":L.tileLayer('https://server.arcgisonline.com/arcgis/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>',
            }),
            "OSM":L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
              attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }),
            "Esri World Gray":L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>',
                maxZoom: 16
            }),
            "Google Street":L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3'],
                    attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
            }),
            "Google Hybrid":L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3'],
                    attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
            }),
            "Google Traffic":L.tileLayer('https://{s}.google.com/vt/lyrs=m@221097413,traffic&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                min5oom: 2,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
            }),
             "Google Terrain":L.tileLayer('https://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{
                 maxZoom: 20,
                 subdomains:['mt0','mt1','mt2','mt3'],
                 attribution:'Map data &copy; Google | Map By <a href="https://idraxy.web.app" target="_blank">Draxgist & Team</a>'
            }),
            // "Stadia OSMBright":L.tileLayer('https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.png',{
            //      attribution:'&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
            // }),
            "CYL" : L.tileLayer('https://dev.{s}.tile.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
            	maxZoom: 20,
            	attribution: '<a href="https://github.com/cyclosm/cyclosm-cartocss-style/releases" title="CyclOSM - Open Bicycle render">CyclOSM</a> | Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            })
        }
    var map = L.map('peta-persebaran', {
        center: [-7.4478, 112.7183],
        zoom: 15,
        preferCanvas:true,
        // wheelPxPerZoomLevel: 110,
        //zoomDelta: 0.2,
        //zoomSnap: 0.2,
        bounceAtZoomLimits:false,
        minZoom: 8,
        dragging : false,
        doubleClickZoom : false,
        // maxZoom: 15,
            maxBounds:[
                [-9.319,110.868],
                [-5.713,116.103]
            ],
        zoomControl:false,
        layers: [
        // 		basemaps["Esri World Gray"]
        // 		basemaps["OSM"]
        // 		basemaps["Esri World Dark"]
            basemaps["Google Terrain"]
        ],
    });
    
    map.scrollWheelZoom.disable();
    
    var layerPolygon = new L.FeatureGroup();
    
    var namaKecamatan = '{!! $kecamatan->nama !!}';
    var pasien = {!! $pasien !!};
    
    var layer_pasien=L.markerClusterGroup({disableClusteringAtZoom : 8});
    var layer_meninggal=L.markerClusterGroup();
    
    pasien.map(p=>{
        
            if(true){
            var imgLocation = "https://covid19.polresta-sidoarjo.com/public/leaflet/icons/pos.png";
            
            var pos=L.latLng(p.lat, p.lng);
            
            var jk = p.jk == 1 ? "Perempuan" : "Laki-laki";
            var status = p.s == null ? '' : p.s;
            
            if(p.s == "Dirawat" || p.s == null)
            {
                if(p.jenis_kasus.id == 1 )
                imgLocation = "https://covid19.polresta-sidoarjo.com/public/leaflet/icons/pos.png";
                else if(p.jenis_kasus.id == 2 )
                imgLocation = "https://covid19.polresta-sidoarjo.com/public/leaflet/icons/odp.png";
                else if(p.jenis_kasus.id == 3 )
                imgLocation = "https://covid19.polresta-sidoarjo.com/public/leaflet/icons/pdp.png";
                
            }
            else if(p.s == "Sembuh")
            {
                imgLocation = "https://covid19.polresta-sidoarjo.com/public/leaflet/icons/sembuh.png";
            }else if(p.s == "Meninggal"){
                imgLocation = "https://covid19.polresta-sidoarjo.com/public/leaflet/icons/meninggal.png";
            }
            

            var marker=L.marker(pos,{icon: L.divIcon({
                                className: 'location-pin',
                                html: '<img src="'+imgLocation+'">',
                                iconAnchor:   [0, -12], 
                                popupAnchor: [0, -12]
                            }), draggable: false
                        })

            var bindPopUpHtml;
            var jenisIsolasi = p.jenis_isolasi == 0 ? 'Mandiri' : 'Rumah Sakit';
            if(p.jenis_kasus.id <= 3)
           bindPopUpHtml =  `
                <h4>Kasus ${p.jenis_kasus.nama}</h4>
                <span>Nama: ${p.nama}</span><br>
                <span>Umur: <b>${p.usia}</b></span><br>
                <span>Jenis Kelamin: <b>${jk}</b></span><br>
                <span>Status: <b>${status}</b></span><br>
                <span>Jenis Isolasi: <b>${jenisIsolasi}</b></span><br>
                <span>Kelurahan: <b>${p.kel_nama}</b></span><br>
                <span>Kecamatan: <b>${p.kec_nama}</b></span><br>
            `;
            else
            bindPopUpHtml = `
                <h4>Kasus ${p.jenis_kasus.nama}</h4>
                <span>Nama: ${p.nama}</span><br>
                <span>Umur: <b>${p.usia}</b></span><br>
                <span>Jenis Kelamin: <b>${jk}</b></span><br>
                <span>Status: <b>${status}</b></span><br>
                <span>Kelurahan: <b>${p.kel_nama}</b></span><br>
                <span>Kecamatan: <b>${p.kec_nama}</b></span><br>
            `;
            marker.bindPopup(bindPopUpHtml);
            
            marker.getPopup().on('remove', function() {
                fokusDesa('{!! $kelurahan->nama !!}');
            });

            marker.on('click', function(e){
                map.setView([e.latlng.lat, e.latlng.lng], 14);
            });

            // marker.bindTooltip(p.nomorkasus);
            if(p.s == "Dirawat" || p.s == null)
            {
                if(p.jenis_kasus.id == 1 )
                marker.addTo(layer_pasien);
                else if(p.jenis_kasus.id == 2 )
                marker.addTo(layer_odp);
                else if(p.jenis_kasus.id == 3 )
                marker.addTo(layer_pdp);
            }
            else if(p.s == "Sembuh")
            {
                marker.addTo(layer_sembuh);
            }else if(p.s == "Meninggal"){
                marker.addTo(layer_meninggal);
            }
            
        }
    })
    
    map.addLayer(layer_pasien);
    
    getPolygons();
    function getPolygons(){
                console.log(namaKecamatan.toLowerCase());
              $.getJSON("https://covid19.polresta-sidoarjo.com/public/geojson/"+namaKecamatan.toLowerCase()+".json",function(data){
                //   console.log(data);
                var datalayer = L.geoJson(data ,{
                    onEachFeature: function(feature, featureLayer) {
                      featureLayer.setStyle({
                        fillOpacity: 0,
                        color: 'red',
                        weight:  1
                      });
                        // console.log(feature);
                      layerPolygon.addLayer(featureLayer)
                    //   console.log(layerPolygon.getLayers().length);
                       fokusDesa('{!! $kelurahan->nama !!}');
                    }
                });
            });
            map.addLayer(layerPolygon)
    }
    var curLayerKec;
    function fokusDesa(nama_desa){
        layerPolygon.eachLayer(function(l){

            //set selected layer to visible
            if(l.feature.properties.DESA.toLowerCase() == nama_desa.toLowerCase())
            {
                l.setStyle({
                    fillColor: "red",
                    fillOpacity: 0.1,
                    weight: 1
                })
                map.fitBounds(l.getBounds(), {
                    padding: [20,20]
                })
            }else{
                l.setStyle({
                    weight: 0,
                    fillOpacity: 0
                })
            }
        })
        // curLayerKec = kec.toLowerCase()
    }
    </script>
    
    <script>
       $(document).ready(function(){     

         $(document).on('click', '.detail', function(){
          $("#alert_results").alert('close');
          $("#mapid3").remove();
          var id = $(this).data('id');
          $('#form_detail').html('');
          $.ajax({
           url: "{{ url('admin/pasien')}}"+'/'+id,
           dataType:"json",
           success:function(html){
              $('#show').modal('show');
              $('input#alamat_ktp').val(html.data.alamat_ktp);
              $('input#petugas').val(html.nama + html.nrp);
              $('input#alamat_sekarang').val(html.data.alamat_ktp);
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

    });
    </script>
@endsection