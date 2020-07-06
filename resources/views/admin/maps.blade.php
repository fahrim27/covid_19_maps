
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Peta COVID-19 Di Sidoarjo">
        <meta name="keywords" content="Peta, Positif, Corona, COVID-19, Sidoarjo">
        <meta name="author" content="ABH Studio">
        <title>Peta COVID-19 POLRESTA SIDOARJO</title>
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.1/dist/leaflet.css" />
        <link rel="stylesheet" href="https://leaflet.github.io/Leaflet.markercluster/dist/MarkerCluster.css" />
        <link rel="stylesheet" href="https://leaflet.github.io/Leaflet.markercluster/dist/MarkerCluster.Default.css" />
        <!--[if lte IE 8]><link rel="stylesheet" href="https://cdn.leafletjs.com/leaflet-0.7.2/leaflet.ie.css" /><![endif]-->
    
    
        <link rel="stylesheet" href="https://turbo87.github.io/sidebar-v2/css/leaflet-sidebar.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-pulse-icon@0.1.0/src/L.Icon.Pulse.css" />
        <link rel="stylesheet" href="https://marslan390.github.io/BeautifyMarker/leaflet-beautify-marker-icon.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.71.1/dist/L.Control.Locate.min.css" />

        
        <link href="{{ asset ('theme/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset ('theme/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset ('theme/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset ('theme/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    
        <style>
            body {
                padding: 0;
                margin: 0;
            }
    
            html, body, #peta-persebaran {
                height: 100%;
                font: 10pt "Helvetica Neue", Arial, Helvetica, sans-serif;
            }

            #peta-persebatan{
                position: absolute;
            }
    
    
    #splashscreen{
        height: 100%;
        width: 100%;
        background-color: #181B2E;
        
    }

    @keyframes fade { 
  from { opacity: 0.5; } 
}

.blinking {
  animation: fade 1s infinite alternate;
}

    #splash{
        position: absolute;
        z-index: 2001;
    }

    html, body {
    height: 100%;
}

.pulse {
  animation: pulse 1s infinite;
  animation-direction: alternate;
  -webkit-animation-name: pulse;
  animation-name: pulse;
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

@keyframes pulse {
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

.fixed-bottom{
    bottom: -24px;
}

.container-fluid{
    padding-left: 0;
    padding-right: 0;
}

.select2{
    min-width: 100%;
    height: 33px;
}
.card{
    border-radius: 0px;
}
.card-body{
    padding: 0px 1.25rem 0px 1.25rem;
}
        </style>
    </head>
    <body>
        
        <div id="splash" class="container-fluid h-100" style="background-color: #181B2E;"> 
            <div class="row h-100 justify-content-center align-items-center"> 
                <form class="col-md-12"> 
                    <div class="text-center">
                        <h2 style="color: #ffd700;">DELTA SIAGA</h2>
                        <h2 style="color: red; font-family: 'Unlock', cursive;">COVID 19</h2>
                        <br>
                        <br>
                        <img class="" src="{{ asset('logo/kampung_tangguh.png') }}" height="300px"><br><br>
                        <h3 class="text-white">POLRESTA SIDOARJO</h3>
                    </div>
                </form> 
            </div> 
        </div>

        <div class="fixed-top animated faster" id="atas">
            <div class="container-fluid">
                <div class="card" style="z-index: 2002;">
                    <div class="card-body" >
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="card-title">Kategori</h6>
                                    <div class="form-group">
                                        <select class="select2" id="kategori">
                                            @foreach ($kategori as $kategori)
                                            <option value="{{ strtolower('layer_'.$kategori->nama) }}">{{ $kategori->nama }}</option>
                                            @endforeach
                                            <option value="layer_sembuh">Sembuh</option>
                                            <option value="layer_meninggal">Meninggal</option>
                                            <option value="layer_posko">Posko</option>
                                            <option value="layer_rs">Rumah Sakit</option>
                                            <option value="layer_pd">Physical Distancing</option>
                                            <option value="layer_napi">Narapidana</option>
                                            <option value="layer_petugas">Petugas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h6 class="card-title">Wilayah</h6>
                                    <div class="form-group">
                                        <select class="select2" id="kecamatan">
                                            <option value="kota">Kabupaten Sidoarjo</option>
                                            @foreach ($kecamatan as $k)
                                        <option value="{{ $k->nama }}" data-id="{{ $k->id }}">{{ $k->nama }}</option>
                                            @endforeach
                                        
                                        </select>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
            </div>
        </div>

        <div class="fixed-bottom animated faster" id="bawah">
            <div class="container-fluid">
                <div class="card " style="z-index: 200002; margin-bottom: 24px;">
                    <div class="card-body text-center">
                        <h6 class="card-title " id="judulData">Kabupaten Sidoarjo</h6>
                        <div class="row">
                            <div class="col-12 text-center text-white" style="padding-bottom: 12px;">
                                <b >POSITIF</b> : <span id="positif">0</span>  |  <b>ODP</b> : <span id="odp">0</span>  |  <b>PDP</b> : <span id="pdp">0</span>  |  <b>Sembuh</b> : <span id="sembuh">0</span>  <br>  <b>Meninggal</b> : <span id="meninggal">0</span>  |  <b>RS</b> : <span id="rs">0</span>  |  <b>Posko</b> : <span id="posko">0</span> |  <b>Napi </b> : <span id="napi">0</span>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>

        <div id="warning" class="fixed-bottom animated faster " style="bottom: 60px; z-index:2000; padding-right: 12px; padding-left: 12px;">
               <div class="container">
                <div class="alert alert-danger">
                    <div class="row">
                        <div class="col-12">
                            <img src="{{ asset('leaflet/icons/warning.png') }}" width="32px">Anda berada dalam zona <b>50M</b> dari pasien Positif
                        </div>
                    </div>
                </div>
               </div>
        </div>
        <div id="peta-persebaran" class="sidebar-map"></div>
    
        
        <script src="https://unpkg.com/leaflet@1.0.1/dist/leaflet.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js"></script>
        <script src="https://turbo87.github.io/sidebar-v2/js/leaflet-sidebar.js"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.71.1/src/L.Control.Locate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/leaflet-pulse-icon@0.1.0/src/L.Icon.Pulse.min.js"></script>
        <script src="https://unpkg.com/beautifymarker@1.0.7/leaflet-beautify-marker-icon.js"></script>

        <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        {{-- check apakah di mobile/dekstop --}}
        <script> 
        $('a').click(function (e){  
            if (e.ctrlKey) {
                return false;
            }
        });
        var mapPadding = [];
            if (window.matchMedia("(max-width: 767px)").matches) 
            { 
                mapPadding = [24,24]
                // The viewport is less than 768 pixels wide 
                console.log("This is a mobile device."); 
            } else { 
                mapPadding = [90,90]
                // The viewport is at least 768 pixels wide 
                console.log("This is a tablet or desktop."); 
            } 
        </script> 

        <script type="text/javascript">
            $(document).ready(function() {
               $('.select2').select2();
           });
        </script>
            <script type="text/javascript">
                    $('.leaflet-control-layers').animate({
                        bottom: "-72px"
                    })
                    $('#warning').hide();
                    $('#splash').hide()
                    $('#atas').hide()
                    $('#bawah').hide()
                    $('#splash').fadeIn(500).delay(2000).fadeOut(500, function(){
                        tambahKelas();
                    });
                    // $('#peta-persebaran').hide().delay(2501).fadeIn(500);
                    
                    function tambahKelas(){
                        $('#atas').show()
                        $('#atas').addClass('fadeInDown');
                        $('#bawah').show()
                        $('#bawah').addClass('fadeInUp');
                        $('.leaflet-control-layers').animate({
                            bottom: "64px"
                        })
                    }
                    
            </script>

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
            basemaps["CYL"]
        ],
    });
    L.control.layers(basemaps, null, {position: 'bottomright'}).addTo(map);
    var myIcon = L.icon({
        iconUrl: "{{ asset('leaflet/icons/my_location.png') }}",
        // className: 'pulse',
        iconSize:     [50, 50], // size of the icon
        iconAnchor:   [25, 45], // point of the icon which will correspond to marker's location
        popupAnchor:  [0, -35] // point from which the popup should open relative to the iconAnchor
    });

    

    var pasien = {!! $pasien !!};
    var rumah_sakit = {!! $rs !!};
    var physical_distance = {!! $pd !!};
    var posko = {!! $posko !!};
    var napi = {!! $napi !!};
    var layer_positif=L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    var layer_sembuh=L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    var layer_meninggal=L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    var layer_odp=L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    var layer_pdp=L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    var layer_meninggal=L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    var layer_sembuh=L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    var layer_rs=L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    var layer_posko=L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    var layer_pd= L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    var layer_napi= L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    var layer_petugas=L.markerClusterGroup({ disableClusteringAtZoom: 8 });
    
    pasien.map(p=>{
        
            if(true){
            var imgLocation = "{{ asset('leaflet/icons/pos.png') }}";
            
            var pos=L.latLng(p.lat, p.lng);
            
            if(p.nama.includes("@"))
            {
                imgLocation = "{{ asset('leaflet/icons/polisi.png') }}";
                
                var marker=L.marker(pos,{icon: L.divIcon({
                                className: 'location-pin',
                                html: '<img src="'+imgLocation+'">',
                                iconAnchor:   [0, -12], 
                                popupAnchor: [0, -12]
                            }), draggable: false
                        })
        
            var bindPopUpHtml;
                
                bindPopUpHtml =  `
                <h4>Kasus ${p.jenis_kasus.nama}</h4>
                <span>Nama: ${p.nama}</span><br>
                <span>Telfon: </span><br>
                <span>Umur: <b>${p.usia}</b></span><br>
                <span>Jenis Kelamin: <b>${p.jk}</b></span><br>
                <span>Status: <b>${p.s}</b></span><br>
                <span>Jenis Isolasi: <b>${jenisIsolasi}</b></span><br>
                <span>Kelurahan: <b>${p.kel_nama}</b></span><br>
                <span>Kecamatan: <b>${p.kec_nama}</b></span><br>
            `;
            
            marker.bindPopup(bindPopUpHtml);
            
            marker.addTo(layer_petugas);
                
            }else{
                if(p.s == "Dirawat" || p.s == null)
            {
                if(p.jenis_kasus.id == 1 )
                imgLocation = "{{ asset('leaflet/icons/pos.png') }}";
                else if(p.jenis_kasus.id == 2 )
                imgLocation = "{{ asset('leaflet/icons/odp.png') }}";
                else if(p.jenis_kasus.id == 3 )
                imgLocation = "{{ asset('leaflet/icons/pdp.png') }}";
                
            }
            else if(p.s == "Sembuh")
            {
                imgLocation = "{{ asset('leaflet/icons/sembuh.png') }}";
            }else if(p.s == "Meninggal"){
                imgLocation = "{{ asset('leaflet/icons/meninggal.png') }}";
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
                <span>Jenis Kelamin: <b>${p.jk}</b></span><br>
                <span>Status: <b>${p.s}</b></span><br>
                <span>Jenis Isolasi: <b>${jenisIsolasi}</b></span><br>
                <span>Kelurahan: <b>${p.kel_nama}</b></span><br>
                <span>Kecamatan: <b>${p.kec_nama}</b></span><br>
            `;
            else
            bindPopUpHtml = `
                <h4>Kasus ${p.jenis_kasus.nama}</h4>
                <span>Nama: ${p.nama}</span><br>
                <span>Umur: <b>${p.usia}</b></span><br>
                <span>Jenis Kelamin: <b>${p.jk}</b></span><br>
                <span>Status: <b>${p.s}</b></span><br>
                <span>Kelurahan: <b>${p.kel_nama}</b></span><br>
                <span>Kecamatan: <b>${p.kec_nama}</b></span><br>
            `;
            marker.bindPopup(bindPopUpHtml);

            marker.on('click', function(e){
                map.setView([e.latlng.lat, e.latlng.lng], 14);
            });

            // marker.bindTooltip(p.nomorkasus);
            if(p.s == "Dirawat" || p.s == null)
            {
                if(p.jenis_kasus.id == 1 )
                marker.addTo(layer_positif);
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
            
        }
    })

    
    physical_distance.map(p=>{
        
        var polyline = p.polyline;
        var arr = polyline.split(",");

        var polylineSatuRs = [];
        var latlng = [];
        var lng = false;
        var loop = 1;
        for(var i = 0; i < arr.length; i++)
        {
            if(loop == 1)
            latlng.push(parseFloat(arr[i])*-1)
            else
            latlng.push(parseFloat(arr[i]))

            loop++;

            if(latlng.length == 2)
            {
                polylineSatuRs.push(latlng)
                latlng = [];
                loop = 1;
            }
            
        }

        var myPoly = L.polyline(polylineSatuRs, {color: 'red', weight: 1.5});
        myPoly.on('click', function(e){
            map.fitBounds(myPoly.getBounds(),{
                padding: mapPadding
            });
        });
        bindPopUpHtml = `
                <h4>${p.nama}</h4><br>
                <span>${p.keterangan}</span>
            `;
        myPoly.bindPopup(bindPopUpHtml);
        layer_pd.addLayer(myPoly);
    })

    map.addLayer(layer_pd)
    
    rumah_sakit.map(p=>{
        
            var imgLocation = "{{ asset('leaflet/icons/rs.png') }}";
            
            var pos=L.latLng(p.lat, p.lng);

            var marker=L.marker(pos,{icon: L.divIcon({
                                className: 'location-pin',
                                html: '<img src="'+imgLocation+'">',
                                iconAnchor:   [0, -12], 
                                popupAnchor: [0, -12]
                            })
                        })

            var bindPopUpHtml;
            
            bindPopUpHtml = `
                <h4>${p.nama}</h4>
                <span>No: <b>${p.no_hp}</b></span><br>
                <span>Jumlah Pasien: <b>${p.jumlah}</b></span><br>
                <span>Kelurahan: <b>${p.kel_nama}</b></span><br>
                <span>Kecamatan: <b>${p.kec_nama}</b></span><br>
            `;
            marker.bindPopup(bindPopUpHtml);
            marker.on('click', function(e){
                map.setView([e.latlng.lat, e.latlng.lng], 14);
            });
            marker.addTo(layer_rs);
        
    })
    
    map.addLayer(layer_rs);
    
    posko.map(p=>{
        
            var imgLocation = "{{ asset('leaflet/icons/posko.png') }}";
            
            var pos=L.latLng(p.lat, p.lng);

            var marker=L.marker(pos,{icon: L.divIcon({
                                className: 'location-pin',
                                html: '<img src="'+imgLocation+'">',
                                iconAnchor:   [0, -12], 
                                popupAnchor: [0, -12]
                            })
                        })

            var bindPopUpHtml;
            var noPosko = p.nomor == null ? '-' : p.nomor;
            bindPopUpHtml = `
                <h4>Posko ${p.nama}</h4>
                <span>No: <b>${noPosko}</b></span><br>
                <span>Kelurahan: <b>${p.kel_nama}</b></span><br>
                <span>Kecamatan: <b>${p.kec_nama}</b></span><br>
            `;
            marker.bindPopup(bindPopUpHtml);
            marker.on('click', function(e){
                map.setView([e.latlng.lat, e.latlng.lng], 14);
            });
            marker.addTo(layer_posko);
        
    })
    
    map.addLayer(layer_posko);
    
    napi.map(p=>{
        
            var imgLocation = "{{ asset('leaflet/icons/napi.png') }}";
            
            var pos=L.latLng(p.lat, p.lng);

            var marker=L.marker(pos,{icon: L.divIcon({
                                className: 'location-pin',
                                html: '<img src="'+imgLocation+'">',
                                iconAnchor:   [0, -12], 
                                popupAnchor: [0, -12]
                            })
                        })

            var bindPopUpHtml;
            bindPopUpHtml = `
                <h4>Nama: ${p.nama}</h4>
                <span>Kelurahan: <b>${p.kel_nama}</b></span><br>
                <span>Kecamatan: <b>${p.kec_nama}</b></span><br>
            `;
            marker.bindPopup(bindPopUpHtml);
            marker.on('click', function(e){
                map.setView([e.latlng.lat, e.latlng.lng], 14);
            });
            marker.addTo(layer_napi);
        
    })
    
    map.addLayer(layer_napi);
    
    function onMapClick(e) {
        var atas = $('#atas');
        if(atas.hasClass('fadeInDown'))
        {
            
            $('#warning').animate({
                bottom: '8px'
            })
            
            $('.leaflet-control-layers').animate({
                bottom: "-72px"
            })
            atas.removeClass('fadeInDown').addClass('fadeOutUp')
        }
        else if(atas.hasClass('fadeOutUp'))
        {
            $('#warning').animate({
                bottom: '60px'
            })
            
            $('.leaflet-control-layers').animate({
                bottom: "64px"
            })
            atas.removeClass('fadeOutUp').addClass('fadeInDown')
        }

        var bawah = $('#bawah');
        if(bawah.hasClass('fadeInUp'))
        bawah.removeClass('fadeInUp').addClass('fadeOutDown')
        else if(bawah.hasClass('fadeOutDown'))
        bawah.removeClass('fadeOutDown').addClass('fadeInUp')
    }

    $('#kategori').on('change', function(){
        gantiLayer($(this).val());
    });

    //daftar layer yang ada
    var semuaLayer = ['layer_positif','layer_odp','layer_pdp','layer_rs','layer_posko','layer_napi','layer_pd','layer_sembuh','layer_meninggal', 'layer_petugas'];
    var copySemuaLayer = [];
    Array.prototype.remove = function() {
        var what, a = arguments, L = a.length, ax;
        while (L && this.length) {
            what = a[--L];
            while ((ax = this.indexOf(what)) !== -1) {
                this.splice(ax, 1);
            }
        }
        return this;
    };

    gantiLayer('layer_positif');

    function gantiLayer(layerTampil){
        // console.log(layerTampil);
        for(var i = 0; i < semuaLayer.length; i++)
        {
            copySemuaLayer.push(semuaLayer[i]);
        }
        
        copySemuaLayer.remove(layerTampil);

        for(var i = 0; i < copySemuaLayer.length; i++)
        {
            // console.log('yang dihapus '+copySemuaLayer[i])
            if(map.hasLayer(window[copySemuaLayer[i]]))
            map.removeLayer(window[copySemuaLayer[i]]);
        }

        copySemuaLayer = [];

        map.addLayer(window[layerTampil]);
    }

    map.on('click', onMapClick);
    

map.on('locationfound', onLocationFound);
map.on('locationerror', onLocationError);


    $('#kecamatan').on('change', function(){
        // getKecamatan();

        var val = $(this).val()
        
        
        $('#judulData').text( val != 'kota' ? 'Kecamatan '+$(this).val() : 'Kota Sidoarjo')
        fokusKec(val);
        // var kecamatan = dataKecamatan.find(x => x.id === $(this).val()).kelurahan;
        setJumlahKecamatan($(this).find(':selected').data('id'))
    })
    var curLayerKec;
    function fokusKec(kec){


        layer_kec.eachLayer(function(l){
            //set current layer to invisible
            if(l.feature.properties.kecamatan.toLowerCase() == curLayerKec)
            {
                l.setStyle({
                    weight: 0,
                    fillOpacity: 0
                })
            }
            //set selected layer to visible
            if(l.feature.properties.kecamatan.toLowerCase() == kec.toLowerCase())
            {
                l.setStyle({
                    fillColor: "red",
                    fillOpacity: 0.1,
                    weight: 1
                })
                map.fitBounds(l.getBounds(), {
                    padding: mapPadding
                })
            }
        })
        curLayerKec = kec.toLowerCase()
    }

    var layer_kec = new L.FeatureGroup();

    getKecamatan();
    function getKecamatan(){

              $.getJSON("{{ asset('leaflet/kecamatan_sda.json') }}",function(data){
                var datalayer = L.geoJson(data ,{
                onEachFeature: function(feature, featureLayer) {
                //   featureLayer.on('click', function(e){
                //     // alert('polygon clicked');
                //     map.fitBounds(e.target.getBounds(), {
                //       padding: mapPadding
                //     })
                //     // map.removeLayer(kotaGroup);
                //   });

                  featureLayer.setStyle({
                    // fillColor: warnaKlien,
                    fillOpacity: 0,
                    color: 'red',
                    weight:  0
                  });

                  layer_kec.addLayer(featureLayer)
                }
                });
            });
            map.addLayer(layer_kec)

            
            // console.log(layer_kec.getBounds())
    }

    

    function loadLayer(layername){
        // console.log(window[layername])
        if(!window[layername]){
            datalayer[layername]()
        }else{
            map.addLayer(window[layername])
        }
        
    }
    
    function changeLayer(layername,value){
        // console.log(window[layername],value);
        if(value){
            loadLayer(layername);
        }else{
            map.removeLayer(window[layername])
        }
    }
    
    function moveLayer(layers){
        layers.eachLayer(function(layer){
            var rand=layer.getLatLng();
            var randLatLng= [
                rand.lat+(Math.random()-.5)/10000,
                rand.lng+(Math.random()-.5)/10000
            ];
            setTimeout(()=>layer.setLatLng(randLatLng),Math.random()*1000);
            
        })
        if (map.getZoom() >12){
            setTimeout(()=>moveLayer(layers),1000);
        }
    }
    
    
    
    var lokasimu=L.featureGroup();
    // lc = L.control.locate({
    //     strings: {
    //         title: "Show Your Location!"
    //     }
    // }).addTo(map);
    // map.locate({setView: true, maximumAge:50000, enableHighAccuracy: true});
    // navigator.geolocation.watchPosition(function(position) {
    
        
    // });
    // setInterval(function() {
    //   map.locate({setView: false,maximumAge:50000, enableHighAccuracy: true});
    // }, 5*1000 * 60);
    
    
    
    function distanceKm(lat1, lon1, lat2, lon2) {
      var R = 6371; // km
      var dLat = toRad(lat2-lat1);
      var dLon = toRad(lon2-lon1);
      var lat1 = toRad(lat1);
      var lat2 = toRad(lat2);
    
      var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
      var d = R * c;
      return d;
    }
    
    // Converts numeric degrees to radians
    function toRad(Value) {
        return Value * Math.PI / 180;
    }
    function dynamicSort(property) {
        var sortOrder = 1;
        if(property[0] === "-") {
            sortOrder = -1;
            property = property.substr(1);
        }
        return function (a,b) {
            /* next line works with strings and numbers, 
             * and you may want to customize it to your needs
             */
            var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
            return result * sortOrder;
        }
    }
    // function setView(lat,lon){
    //     // console.log(lat,lon)
    //     map.setView([lat,lon],15)
    //     window.location.hash=`${lat},${lon}`;
    //     layer_rumahsakit.eachLayer(function(layer){
    //         if(layer._latlng.lat==lat){
    //             layer.openPopup()
    //         }
    //     })
    // }
    var markerposisi;

    var jumlahPerKecamatan = {!! $kecamatan !!};
    var jumlahSidoarjo = {'positif':0,'odp':0,'pdp':0,'rs':0,'posko':0,'pd':0, 'sembuh':0,'meninggal':0,'napi':0}
    var jenisKasus = ['positif','odp','pdp', 'rs', 'posko', 'pd', 'sembuh', 'meninggal', 'napi']
    var firstLoad = true;
    
    setJumlah();
    function setJumlah(){
        pasien.forEach(e => {
            for(var i = 0 ; i < jumlahPerKecamatan.length; i++)
            {
                if(e.kec_id == jumlahPerKecamatan[i]['id'])
                {
                    if(e.s == "Dirawat")
                    {
                        jumlahPerKecamatan[i][jenisKasus[e.status-1]] = jumlahPerKecamatan[i][jenisKasus[e.status-1]]+1;
                    }else if(e.s == "Sembuh"){
                        jumlahPerKecamatan[i]["sembuh"] = jumlahPerKecamatan[i]["sembuh"]+1;
                    }else if(e.s == "Meninggal"){
                        jumlahPerKecamatan[i]["meninggal"] = jumlahPerKecamatan[i]["meninggal"]+1;
                    }
                    if(firstLoad)
                    {
                        if(e.s == "Dirawat"){
                        jumlahSidoarjo[jenisKasus[e.status-1]]+=1;
                        }else if(e.s == "Sembuh")
                        jumlahSidoarjo["sembuh"]+=1;
                        else if (e.s == "Meninggal")
                        jumlahSidoarjo["meninggal"]+=1;
                    }

                    break;
                }
            }
        });

        rumah_sakit.forEach(e => {
            for(var i = 0 ; i < jumlahPerKecamatan.length; i++)
            {
                if(e.kec_id == jumlahPerKecamatan[i]['id'])
                {
                    jumlahPerKecamatan[i]['rs'] = jumlahPerKecamatan[i]['rs']+1;
                    
                    if(firstLoad)
                    jumlahSidoarjo['rs']+=1;

                    break;
                }
            }
        });
        
        posko.forEach(e => {
            for(var i = 0 ; i < jumlahPerKecamatan.length; i++)
            {
                if(e.kec_id == jumlahPerKecamatan[i]['id'])
                {
                    jumlahPerKecamatan[i]['posko'] = jumlahPerKecamatan[i]['posko']+1;
                    
                    if(firstLoad)
                    jumlahSidoarjo['posko']+=1;

                    break;
                }
            }
        });
        
        napi.forEach(e => {
            for(var i = 0 ; i < jumlahPerKecamatan.length; i++)
            {
                if(e.kec_id == jumlahPerKecamatan[i]['id'])
                {
                    jumlahPerKecamatan[i]['napi'] = jumlahPerKecamatan[i]['napi']+1;
                    
                    if(firstLoad)
                    jumlahSidoarjo['napi']+=1;

                    break;
                }
            }
        });

        firstLoad = false;

        setJumlahKota();
    }

    function setJumlahKota(){
        for(e in jumlahSidoarjo)
        {
            $('#'+e).text(jumlahSidoarjo[e])
        }
    }

    function setJumlahKecamatan(kec_id){
        
        for(var i = 0; i < jumlahPerKecamatan.length; i++)
        {
            if(jumlahPerKecamatan[i]['id'] == kec_id)
            {
                jenisKasus.forEach(e => {
                    console.log(jumlahPerKecamatan[i][e])
                    $('#'+e).text(jumlahPerKecamatan[i][e])
                });
            }
        }
    }

    function onLocationFound(e) {
    var radius = e.accuracy;
    var pos=L.latLng(e.latlng);

    console.log(e.latlng);

    // L.marker(e.latlng, {icon: myIcon}).addTo(map)
    //     .bindPopup("You are within " + radius + " meters from this point").openPopup();

        var jumlahpos={ap:0,ao:0,apd:0,bp:0,bo:0,bpd:0,cp:0,co:0,cpd:0};
        var jarakpos = pasien.map(p=>{
            if(p.lat!=''){
                var dist=distanceKm(e.latlng.lat,e.latlng.lng,p.lat,p.lng)
                // console.log(dist)
                if(dist<=.05){
                    if(p.s == "Dirawat" || p.s == null)
                    {
                        if(p.status == 1)
                        jumlahpos.ap+=1;
                        if(p.status == 2)
                        jumlahpos.ao+=1;
                        if(p.status == 3)
                        jumlahpos.apd+=1;
                    }
                }
                if(dist<=.5){
                    if(p.s == "Dirawat" || p.s == null)
                    {
                        if(p.status == 1)
                        jumlahpos.bp+=1;
                        if(p.status == 2)
                        jumlahpos.bo+=1;
                        if(p.status == 3)
                        jumlahpos.bpd+=1;
                    }
                }
                if(dist<=1){
                    if(p.s == "Dirawat" || p.s == null)
                    {
                        if(p.status == 1)
                        jumlahpos.cp+=1;
                        if(p.status == 2)
                        jumlahpos.co+=1;
                        if(p.status == 3)
                        jumlahpos.cpd+=1;
                    }
                }
            }
        })

        //jika pasien berada pada 50 meter akan menampilkan warning
        if(jumlahpos.a > 0)
        {
            $('#warning').show();
            playAudio();
        }

          
        L.circle(pos, 50).setStyle({ 
            color: "red"
        }).addTo(lokasimu);
        L.circle(pos, 500).setStyle({ 
            color: "orange"
        }).addTo(lokasimu);
        L.circle(pos, 1000).setStyle({ 
            color: "yellow"
        }).addTo(lokasimu);
        // console.log(jarakpos,jumlahpos);
        markerposisi=L.marker(pos,{draggable:false}).addTo(lokasimu)
            .bindPopup(`
            <div class="text-center">
                <h4><b>Anda berada di titik ini!</b></h4>
                <h5><b>Kasus Positif, ODP, PDP didekat Anda</b></h5>
                <b>Di radius 50m ada <br> Positif : ${jumlahpos.ap} | ODP : ${jumlahpos.ao} | PDP : ${jumlahpos.apd}</b><br><br>
                <b>Di radius 500m ada <br> Positif : ${jumlahpos.bp} | ODP : ${jumlahpos.bo} | PDP : ${jumlahpos.bpd}</b><br><br>
                <b>Di radius 1km ada <br> Positif : ${jumlahpos.cp} | ODP : ${jumlahpos.co} | PDP : ${jumlahpos.cpd}</b><br><br>
                
            </div>`).openPopup();
    // L.circle(e.latlng, radius).addTo(map);

                // map.fitBounds(lokasimu.getBounds(), {
                //     //   padding: mapPadding
                // });

                // map.fitBounds(layer_kec.getBounds());

                
}

                map.addLayer(lokasimu);
                map.locate({setView: true, maxZoom: 14.5});




function playAudio(){
    console.log('play warning audio');
    // var myAudio = new Audio('{{ asset("sounds/warning.ogg") }}'); 
    // myAudio.addEventListener('ended', function() {
    //     this.currentTime = 0;
    //     this.play();
    // }, false);
    // myAudio.play();
    var sound = new Audio('{{ asset("sounds/warning.ogg") }}');
    // sound.loop = true;
    sound.play();
    // if(playPromise !== undefined){
    //     playPromise.then(function(){
    //         sound.pause();
    //     }).catch(function(error){
    //         // console.error(error);
    //         //....
    //     });
    // }
}




function onLocationError(e) {
    alert(e.message);
}

    
    </script>
    
    </body>
    </html>
    