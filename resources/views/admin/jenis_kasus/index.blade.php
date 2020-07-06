@extends('admin.app')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Data Jenis Kasus</h4>
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
                                                    <th>Id</th>
                                                    <th>Nama Jenis Kasus</th>
                                                    <th>Dibuat Pada</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @php $i=1 @endphp
                                            <tbody id="organisasi_body">
                                                @foreach($getAllJenisKasus as $kasus)
                                                <tr id="item{{$kasus->id}}">
                                                    <td>{!! $kasus->id !!}</td>
                                                    <td>{!! $kasus->nama !!}</td>
                                                    <td>{{date('j F Y', strtotime ($kasus->created_at))}}</td>
                                                    <td>
                                                        <a data-id="{{$kasus->id}}" class="btn btn-outline-warning edit" data-toggle="modal" ><i class="fas fa-edit" style="color: white;"></i></a>
                                                        <a data-id="{{$kasus->id}}" class="btn btn-outline-danger delete"><i class="fas fa-trash" style="color: white;"></i></a>
                                                      </td>
                                                </tr>

<!-- modal-->
<div class="modal fade bs-example-modal-center" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Data Jenis Kasus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="" action="{{route('admin.jenis_kasus.update', $kasus->id)}}" method="post">
                    @csrf
                    {{method_field('put')}}
                    <div class="form-group">
                        <label>Nama Jenis Kasus</label>
                        <input id="nama" type="text" name="nama" class="form-control" />
                    </div>
                    <div class="form-group">
                        <div>
                            <input type="hidden" id="id" name="id" />
                            <button name="action_edit" id="action_edit" type="submit" class="btn btn-primary waves-effect waves-light">Edit</button>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Tambah Data Jenis Kasus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="" action="{{route('admin.jenis_kasus.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nama Jenis Kasus</label>
                        <input id="nama" type="text" name="nama" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
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
           url:'jenis_kasus/' + id +'/edit',
           dataType:"json",
           success:function(html){
              $('#edit_modal').modal('show');
              $('input#nama').val(html.data.nama);
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
                    url: "{{ url('admin/jenis_kasus')}}"+'/'+id,
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

</script>

@endsection