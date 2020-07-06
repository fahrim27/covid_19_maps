@extends('admin.app')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Data Pengguna</h4>
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
                                                    <th>Id</th>
                                                    <th>Nama</th>
                                                    <th>Nrp</th>
                                                    <th>Role Permission</th>
                                                    <th>Status</th>
                                                    <th>Total Penambahan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @php $i=1 @endphp
                                            <tbody id="organisasi_body">
                                                @foreach($users as $user)
                                                <tr id="item{{$user->id}}">
                                                    <td>{{ $user->id }}</td>
                                                    <td>{!! $user->name !!}</td>
                                                    <td>{{ $user->nrp }}</td>
                                                    <td>{{ $user->role == 1 ? 'Admin' : 'Petugas' }}</td>
                                                    <td>
                                                        @if($user->isOnline())
                                                        <li class="text-success"> Online</li>
                                                        @else
                                                        <li class="text-muted"> Offline</li>
                                                        @endif
                                                    </td>
                                                    <td>{{$user->pasien->count()}} data Pasien</td>
                                                    <td>
                                                        <a href="#user-{{$user->id}}" class="btn btn-outline-info info" data-toggle="modal" data-target="#user-{{$user->id}}"><i class="fas fa-info-circle" style="color: white;"></i></a>
                                                      </td>
                                                </tr>


<div class="modal fade bs-example-modal-center" id="user-{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Petugas ini telah menambahkan {{$user->pasien->count()}} pasien. Lihat historynya dibawah ini!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container overflow-auto" style="max-height: 700px;">
                    <div class="" style="color: white; font-size: 14px;">
                        @php $x= 1 @endphp
                        @foreach($user->pasien as $pasien)
                        <ul class="list-group">
                          <li class="list-group-item list-group-item-dark">
                            <span class="" style="color: white; font-size: 14px;"><span class="badge badge-secondary badge-pill">{{$x++}}. </span> Petugas ini telah menambahak pasien dengan detail sebagai berikut, nama: <strong>{{$pasien->nama}}</strong>, nik <strong>{{$pasien->nik}}</strong>, dan jenis isolasi pasien <strong>{{ $pasien->jenis_isolasi == 0 ? 'Mandiri' : 'Rumah Sakit' }}</strong>. ({{ $pasien->created_at != null ? $pasien->created_at->diffForHumans() : ''}})</span>
                          </li>
                        </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


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

@endsection


@section('scripts')

<script>

    $(document).ready(function(){     

            $('.delete').click(function () {
                var id = $(this).data("id");
                var obj = $(this);
                if(confirm("Are You sure want to delete !")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/rumah_sakit')}}"+'/'+id,
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



    // navigator.geolocation.getCurrentPosition(function(location) {
      
    // });

</script>

@endsection