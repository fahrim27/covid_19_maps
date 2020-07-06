@extends('admin.app')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Data Semua Pasien</h4>
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
                                                    <th>No Telp</th>
                                                    <th>Nama</th>
                                                    <th>Usia</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Kasus</th>
                                                    <th>Status</th>
                                                    <th>Isolasi</th>
                                                    <th>Kelurahan</th>
                                                    <th>Petugas</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @php $i=1 @endphp
                                            <tbody id="organisasi_body">
                                                @foreach($getAllPasien as $ps)
                                                <tr id="item{{$ps->id}}">
                                                    <td>{{ $ps->nik }}</td>
                                                    <td>{!! $ps->nama !!}</td>
                                                    <td>{{ $ps->usia }} th</td>
                                                    <td>{{ $ps->jenis_kelamin == 0 ? 'Laki-Laki' : 'Perempuan' }}</td>
                                                    <td>{{ $ps->jenis_kasus->nama }}</td>
                                                    <td>{{ $ps->status }}</td>
                                                    <td>{{ $ps->jenis_isolasi == 0 ? 'Mandiri' : $ps->jenis_isolasi == 2 ? 'Delta Maya' : $ps->jenis_isolasi == 3 ? 'Lingkar Timur' : 'Rumah Sakit' }}</td>
                                                    <td>{{$ps->kelurahan->nama}}</td>
                                                    <td>{{$ps->petugas->name}} ({{$ps->petugas->nrp}})</td>
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
{{--                             {{$getAllDesa->links()}} --}}
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
</div>


<div class="modal fade bs-example-modal-center" id="show" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Detail Pasien</h5>
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

@endsection


@section('scripts')

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

    // navigator.geolocation.getCurrentPosition(function(location) {
      
    // });

</script>

@endsection