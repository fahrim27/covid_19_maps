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
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-2">
                        <div class="d-print-none mo-mt-2">
                            <div class="text-right">
                                        <!-- Small modal -->
                            <button  type="button" class="btn btn-primary waves-effect waves-light" data-target="#create" data-toggle="modal">Tambah Data</button>
                            @can('can_admin')
                            <button style="margin-top: 2%;" type="button" class="btn btn-primary waves-effect waves-light"
                            data-toggle="modal" data-target="#import">Import
                            Data</button>
                            @endcan
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
                                                    <th>Id</th>
                                                    <th>Nama</th>
                                                    <th>Nrp</th>
                                                    <th>Role Permission</th>
                                                    <th>Pasien</th>
                                                    <th>Dibuat Pada</th>
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
                                                    <td>
                                                        @if($user->role == 0)
                                                        Super Admin
                                                        @elseif($user->role == 1)
                                                        Admin
                                                        @elseif($user->role == 2)
                                                        Petugas
                                                        @elseif($user->role == 3)
                                                        Posko
                                                        @elseif($user->role == 4)
                                                        Pasien
                                                        @elseif($user->role == 5)
                                                        Delta Maya
                                                        @else
                                                        Lingkar Timur
                                                        @endif
                                                    <td>
                                                        <p class="text-success"> {{ $user->pasien()->count() }}</p>
                                                        
                                                    </td>
                                                    <td>{{date('j F Y', strtotime ($user->created_at))}}</td>
                                                    @if($user->pasien->count() > 0)
                                                    <td>
                                                        <a data-id="{{$user->id}}" class="btn btn-outline-warning edit" data-toggle="modal" ><i class="fas fa-edit" style="color: white;"></i></a>
                                                    </td>
                                                    @else
                                                        @if(Auth::user()->role == 0)
                                                        <td>
                                                            @if(in_array($user->role, [1,2]))
                                                                <a data-id="{{$user->id}}" class="btn btn-outline-warning edit" data-toggle="modal" ><i class="fas fa-edit" style="color: white;"></i></a>
                                                                <a data-id="{{$user->id}}" class="btn btn-outline-danger delete"><i class="fas fa-trash" style="color: white;"></i></a>
                                                            @else
                                                            <span class="text-warning">Akses tidak Diberikan</span>
                                                            @endif
                                                        </td>
                                                        @else
                                                        <td>
                                                            @if($user->role == 2)
                                                            <a data-id="{{$user->id}}" class="btn btn-outline-warning edit" data-toggle="modal" ><i class="fas fa-edit" style="color: white;"></i></a>
                                                            <a data-id="{{$user->id}}" class="btn btn-outline-danger delete"><i class="fas fa-trash" style="color: white;"></i></a>
                                                            @elseif($user->pasien->count() > 0)
                                                            <span class="alert alert-danger">Petugas ini Mempunyai data Pasien</span>
                                                            @else
                                                            <span class="text-warning">Akses tidak Diberikan</span>
                                                            @endif
                                                        </td>
                                                        @endif
                                                    @endif
                                                </tr>

<!-- modal-->
<div class="modal fade bs-example-modal-center" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="" action="{{route('admin.user.update', $user->id)}}" method="post">
                    @csrf
                    {{method_field('put')}}
                    <div class="form-group">
                        <label>Nama Pengguna</label>
                        <input id="name" type="text" name="name" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Nrp Pengguna</label>
                        <input id="nrp" type="text" name="nrp" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <input type="hidden" id="id" name="id" value="{{$user->id}}">
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
                <h5 class="modal-title mt-0">Tambah Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="" action="{{route('admin.user.store')}}"  method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nama Pengguna</label>
                        <input id="name" type="text" name="name" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    <div class="form-group">
                        <label>Nrp Pengguna</label>
                        <input id="nrp" type="text" name="nrp" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
                    </div>
                    @if(Auth::user()->role == 0)
                    <div class="form-group">
                        <label>Role Pengguna</label>
                        <select id="role" name="role" class="form-control select2">
                          <option value="" selected disabled>Select</option>
                          <option value="0">Super Admin</option>
                          <option value="1">Admin</option>
                      </select>
                    </div>
                    @else
                    <div class="form-group">
                        <label>Role Pengguna</label>
                        <select id="role" name="role" class="form-control select2">
                          <option value="" selected disabled>Select</option>
                          <option value="1">Admin</option>
                          <option value="2">Petugas</option>
                          <option value="5">Delta Mayang</option>
                          <option value="6">Lingkar Timur</option>
                      </select>
                    </div>
                    @endif
                    <div class="form-group">
                        <label>Password</label>
                        <input id="password" type="password" name="password" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
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

@can('can_admin')
<!-- modal-->
<div class="modal fade bs-example-modal-center" id="import" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Import Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="" id="export_excel" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Role Pengguna</label>
                        <select id="role" name="role" class="form-control select2">
                          <option value="" selected disabled>Select</option>
                          <option value="1">Admin</option>
                          <option value="2">Petugas</option>
                          <option value="5">Dinas Kesehatan</option>
                          <option value="6">Lingkar Timur</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Lampirkan File Disini</label>
                        <input id="file" type="file" name="file" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
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
@endcan

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
           url:'user/' + id +'/edit',
           dataType:"json",
           success:function(html){
              $('#edit_modal').modal('show');
              $('input#name').val(html.data.name);
              $('input#nrp').val(html.data.nrp);
              $('input#password').val(html.data.password);
              $('select#role option[value=' + html.data.role +']').attr('selected','selected');
            $('input#id').val(html.data.id);
           
           }
          })
         });

            $('.delete').click(function () {
                var id = $(this).data("id");
                var obj = $(this);
                if(confirm("Are You sure want to delete !")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/user')}}"+'/'+id,
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


            $('#export_excel').on('submit', function(event){
              event.preventDefault();
                   $.ajax({
                    url:"{{ route('admin.import.user') }}",
                    method:"POST",
                    data: new FormData(this),
                    contentType: false,
                    cache:false,
                    processData: false,
                    dataType:"json",
                    success:function(data)
                    {
                     var html = '';
                     if(data.errors)
                     {
                      // html = '<div class="alert alert-danger">';
                      // for(var count = 0; count < data.errors.length; count++)
                      // {
                      //  html += '<p>' + data.errors[count] + '</p>';
                      // }
                      // html += '</div>';
                      swal(
                            {
                                title: 'Export Gagal!',
                                text: data.errors,
                                type: 'error',
                                confirmButtonClass: 'btn btn-success',
                                // cancelButtonClass: 'btn btn-danger ml-2'
                            }
                        )
                     }
                     if(data.success)
                     {

                     //  html = '<div id="alert_results" class="alert alert-success">' + data.success + '</div>';
                     //  $('#export_excel')[0].reset();
                     //  $('#import').modal('hide');
                      
                     // }
                     // $(".alert").alert('close');
                     // $('#results').prepend(html);
                     swal(
                            {
                                title: 'Export Dpt Berhasil!',
                                text: 'Silahkan Proses untuk melanjutkannya.',
                                type: 'error',
                                showConfirmButton: false,
                                timer: 9000
                                // cancelButtonClass: 'btn btn-danger ml-2'
                            }
                        )
                     }
                    },
                    complete: function(){
                        $.LoadingOverlay("hide");
                        window.location.reload(true);
                    }
                   });
                $.LoadingOverlay("show");
          });

    });



    // navigator.geolocation.getCurrentPosition(function(location) {
      
    // });

</script>

@endsection