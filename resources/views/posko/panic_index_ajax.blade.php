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
                                                    @if($pc->status == 1)
                                                        <span id="panic_sound"></span>
                                                    @endif
                                                    <td>{{date('j F Y', strtotime ($pc->created_at))}}</td>
                                                    <td>
                                                        <a href="whatsapp://send?phone={{$pasien['nik']}}" class="btn btn-outline-success"><i class="fab fa-whatsapp"></i></a>
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