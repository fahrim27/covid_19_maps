<div class="row" id="update-div">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            
                            <div id="table-pasien" class="table-rep-plugin" >
                            <div class="table-responsive b-0" data-pattern="priority-columns">
                            
                            <table id="tech-companies-1" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Nama Pasien</th>
                                                    <th>Skor</th>
                                                    <th>Suhu</th>
                                                    <th>1</th>
                                                    <th>2</th>
                                                    <th>3</th>
                                                    <th>4</th>
                                                    <th>5</th>
                                                    <th>6</th>
                                                    <th>7</th>
                                                    <th>8</th>
                                                    <th>9</th>
                                                    <th>10</th>
                                                    <th>11</th>
                                                    <th>12</th>
                                                    <th>13</th>
                                                    <th>14</th>
                                                    <th>15</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @php $i=1 @endphp
                                            <tbody id="organisasi_body">
                                                @foreach($dataPasien as $positif)
                                                <tr id="item{{$positif->id}}">
                                                   
                                                    <td>{!! $positif->nama !!}<br>
                                                    @if($positif->user_id != NULL)
                                                        <?php $nrp = App\User::select('nrp')->whereId($positif->user_id)->first() ?>
                                                        <span class="badge badge-primary">{{$nrp['nrp']}}</span>
                                                    @endif
                                                    </td>
                                                    </div>
                                                    <?php $dateNow = date("Y-m-d"); $p = App\Penilaian::where('user_id', $positif->user_id)->where('tanggal', $dateNow)->get();?>
                                                    @if($p->count() == 0)
                                                    <td class="text-center" colspan="17"><i>- Pasien belum melakukan login hari ini -</i></td>
                                                    @else
                                                    @foreach($p as $rundown)
                                                        @if($loop->iteration <= 2)
                                                        @if($loop->iteration == 1)                     
                                                            @if($rundown->keterangan == 0 )<span class="badge badge-success">Normal</span>
                                                            @elseif($rundown->keterangan == NULL)<span></span>@else {{$rundown->keterangan}} &#176;@endif</td>
                                                        @else
                                                            <?php $jamNow = date('H.i');
                                                                $jamRundown = explode('-', $rundown->rundown->jam);
                                                            ?>
                                                            
                                                            @if($rundown->status == 0)
                                                            <td class="text-center"><i class="fas fa-sad-tear text-warning" style="font-size: 16px;"></i></td>
                                                            @elseif($rundown->status == 0 && $jamNow > $jamRundown[1]  )
                                                            <td class="text-center"><i class="fas fa-sad-tear text-danger" style="font-size: 16px;"></i></td>
                                                            @else
                                                            <td class="text-center"><a href="#detail-{{$rundown->id}}" data-target="#detail-{{$rundown->id}}" data-toggle="modal"><i class="fas fa-smile-beam text-success" style="font-size: 16px;"></i></a></td>
                                                            
                                                            <div class="modal fade bs-example-modal-center" id="detail-{{$rundown->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title mt-0">Detail Assesment {{$rundown->rundown->jam}}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <span id="form_detail"></span>
                                                                                <div class="form-group">
                                                                                    <label>Keterangan</label>
                                                                                    <input value="{{$rundown->keterangan}}" readonly type="text" name="keterangan" readonly class="form-control border border-light"/>
                                                                                </div>    
                                                                                <div class="form-group">
                                                                                    <label>Foto</label>
                                                                                    <div class="text-center">
                                                                                        <img src="{{asset('laporan/penilaian/'.$rundown->foto)}}">
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>

                                                            
                                                            @endif
                                                        @endif
                                                        @endif
                                                    @endforeach
                                                    @endif
                                                    {{-- <td>{{date('j F Y', strtotime ($rs->created_at))}}</td> --}}
                                                    <td>
                                                        @if($positif->nik == NULL)
                                                        <a href="#" class="btn btn-outline-danger"><i class="fab fa-whatsapp" style="color: white;"></i></a>
                                                        @else
                                                        <a href="whatsapp://send?phone={{$positif->nik}}" class="btn btn-outline-success"><i class="fab fa-whatsapp" style="color: white;"></i></a>
                                                        @endif
                                                        <a href="#addtest{{$positif->id}}" class="btn btn-outline-info"><i class="fas fa-file-medical" data-target="#addtest{{$positif->id}}" data-toggle="modal" style="color: white;"></i></a>
                                                        {{-- <a data-id="{{$positif->id}}" class="btn btn-outline-danger detail" data-toggle="modal"><i class="fas fa-pencil-alt" style="color: white;"></i></a> --}}
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