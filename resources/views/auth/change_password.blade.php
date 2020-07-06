@extends('admin.app')

@section('content')

<div class="content-page">
	<div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Ubah Password Anda Disini</h4>
                    </div>
                </div> <!-- end row -->
            </div>
            <span id="results"></span>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                        	<form class="" action="{{route('admin.auth.change_password')}}" method="PATCH">
			                    @csrf
			                    <div class="form-group">
			                        <label>Password Lama</label>
			                        <input id="current_password" type="password" name="current_password" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
			                        <p class="help-block"></p>
			                        @if($errors->has('current_password'))
			                            <p class="help-block">
			                                {{ $errors->first('current_password') }}
			                            </p>
			                        @endif
			                    </div>
			                    <div class="form-group">
			                        <label>Password Baru</label>
			                        <input id="new_password" type="password" name="new_password" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
			                        <p class="help-block"></p>
			                        @if($errors->has('new_password'))
			                            <p class="help-block">
			                                {{ $errors->first('new_password') }}
			                            </p>
			                        @endif
			                    </div>
			                    <div class="form-group">
			                        <label>Konfirmasi Password Baru</label>
			                        <input id="new_password_confirmation" type="password" name="new_password_confirmation" class="form-control border border-light" placeholder=" . . . . . . . . . . . " />
			                        <p class="help-block"></p>
			                        @if($errors->has('new_password_confirmation'))
			                            <p class="help-block">
			                                {{ $errors->first('new_password_confirmation') }}
			                            </p>
			                        @endif
			                    </div>					                    
			                    <div class="form-group">
			                        <div>
			                            <button name="action" id="action" value="Add" type="button" data-toggle="modal" data-target="#change" class="btn btn-primary waves-effect waves-light">Submit</button>
			                        </div>
			                    </div>

			                    <div class="modal fade change" id="change" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
							    aria-hidden="true">
								    <div class="modal-dialog modal-dialog-centered">
								        <div class="modal-content">
								            <div class="modal-header">
								                <h5 class="modal-title mt-0">Ubah Password Konfirmasi</h5>
								                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								                    <span aria-hidden="true">&times;</span>
								                </button>
								            </div>
								            <div class="modal-body">
								                <p>Silahkan Klik Lanjut jika anda sudah yakin untuk mengubah Password.</p>
								            </div>
								            <div class="modal-footer">
								                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
								                <button type="submit" id="change" class="btn btn-danger">Lanjutkan</button>
								            </div>
								        </div><!-- /.modal-content -->
								    </div><!-- /.modal-dialog -->
								</div><!-- /.modal -->
			                </form>

                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection