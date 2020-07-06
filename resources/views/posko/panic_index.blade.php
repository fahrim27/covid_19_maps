@extends('admin.app')

@push('styles')
    <style>
        .button-panic {
          -webkit-animation: glowing 1500ms infinite;
          -moz-animation: glowing 1500ms infinite;
          -o-animation: glowing 1500ms infinite;
          animation: glowing 1500ms infinite;
        }
        @-webkit-keyframes glowing {
          0% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
          50% { background-color: #FF0000; -webkit-box-shadow: 0 0 40px #FF0000; }
          100% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
        }
        
        @-moz-keyframes glowing {
          0% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
          50% { background-color: #FF0000; -moz-box-shadow: 0 0 40px #FF0000; }
          100% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
        }
        
        @-o-keyframes glowing {
          0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
          50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
          100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
        }
        
        @keyframes glowing {
          0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
          50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
          100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
        }
    </style>
@endpush

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Laporan Panic Button</h4>
                    </div>
                    <div class="col-sm-4">
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
                                        <table id="panic_update" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Nama Pasien</th>
                                                    <th>Wa Pasien</th>
                                                    <th>Dilaporkan Pada</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @php $i=1 @endphp
                                            <tbody id="organisasi_body">
                                                @foreach($panic as $pc)
                                                 <?php $pasien = App\Pasien::where('id', $pc->pasien_id)->first() ?> 
                                                <tr id="item{{$pc->id}}">
                                                    <td>{!! $pc->id !!}</td>
                                                    <td>{!! $pasien['nama'] !!}</td>
                                                    <td>{{$pasien['nik']}}</td>
                                                    <td>{{date('j F Y', strtotime ($pc->created_at))}}</td>
                                                    @if($pc->status == 1)
                                                        <span id="panic_sound"></span>
                                                    @endif
                                                    <td>
                                                        <a href="whatsapp://send?phone={{$pasien['nik']}}" class="btn btn-outline-success"><i class="fab fa-whatsapp" style="color: white;"></i></a>
                                                        @if($pc->status == 0)
                                                        <a onclick="event.preventDefault();
                                                     document.getElementById('panic-id').submit();" class="btn btn-outline-danger button-panic"><i class="fa fa-edit"></i></a>
                                                        <form action="{{route('posko.panic.update')}}" method="post" id="panic-id">
                                                            @csrf
                                                            {{method_field('put')}}
                                                            <input type="hidden" id="id" name="id_panic" value="{{$pc->id}}">
                                                            <input type="hidden" name="status" value="1">
                                                        </form>

<div class="modal fade bs-example-modal-center" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Silahkan Lakukan Tindakan Untuk Laporan Ini</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form class="" action="{{route('posko.panic.update')}}" method="post">
                        @csrf
                        {{method_field('put')}}
                        <input type="hidden" id="id" name="id_panic" value="{{$pc->id}}">
                        <input type="hidden" name="status" value="1">
                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Mengerti dan Segera Lakukan Penanganan</button>
                                <button type="button" class="btn btn-secondary waves-effect m-l-5" data-dismiss="modal">
                                    Tunda Penanganan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
                                                        @else
                                                        @endif
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
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
</div>

@endsection


@section('scripts')

<script>

    function loadlink(){
        $('#panic_update').load('/posko/ajax/panic');
        // console.log('TESTING!!!!');
    }
    
function playAudio(){
    console.log('play warning audio');
    var sound = new Audio('{{ asset("sounds/warning.ogg") }}');
    // sound.loop = true;
    sound.play();
}

    loadlink();
    setInterval(function(){
        <?php
            $posko_id = DB::table('posko_user')->where('user_id', Auth::user()->id)->first();
            $posko = App\Posko::where('id', $posko_id->posko_id)->first();
            if(App\Panic::where('kelurahan_id', $posko->kelurahan_id)->where('status', 0)->exists()){
                
        ?>
            playAudio()
        <?php } ?>
        loadlink()
    }, 3000);
    
</script>

@endsection