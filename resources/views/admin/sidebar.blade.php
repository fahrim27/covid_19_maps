 <!-- ========== Left Sidebar Start ========== -->
 <div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

       
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                @if(Auth::user()->role == 4)
                <li class="menu-title">Menu</li>
                    <li>
                        <a href="{{route('pasien.laporan.index')}}" class="waves-effect">
                            <i class="icon-accelerator"></i><span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span> Laporan Harian Anda <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="submenu">
                            @can('can_pasien')
                            <li><a href="{{ route ('pasien.penilaian1.index') }}"> Deteksi Dini </a></li>
                            @endcan
                            <li><a href="{{ route ('pasien.penilaian2.index') }}"> Laporan Kegiatan </a></li>
                        </ul>
                    </li>
                    <li>
                        <a onclick="event.preventDefault();document.getElementById('panic-button').submit();" class="waves-effect">
                            <i class="icon-accelerator"></i><span> Panic Button </span>
                        </a>
                        <form id="panic-button" action="{{route('pasien.panic.store')}}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                        <?php 
                            $pasien = App\Pasien::where('user_id', Auth::user()->id)->first();
                            $posko_wa = App\Posko::select('phone')->where('kelurahan_id', $pasien->kelurahan_id)->first()->phone; ?>
                    <li>
                        <a href="whatsapp://send?phone={{$posko_wa}}" class="waves-effect">
                            <i class="fab fa-whatsapp"></i><span> Hubungi Posko</span>
                        </a>
                    </li>
                @elseif(Auth::user()->role == 3)
                <li class="menu-title">Menu</li>
                    <li>
                        <a href="{{route('posko.fitur.index')}}" class="waves-effect">
                            <i class="icon-accelerator"></i><span> Dashboard </span>
                        </a>

                    </li>
                    @can('can_posko')
                    <li>
                        <a href="{{route('posko.pasien.positif')}}" class="waves-effect">
                            <i class="fas fa-users"></i><span> Data Pasien </span>
                        </a>
                    </li>
                    @endcan
                    @can('can_posko')
                    <li>
                        <a href="{{route('posko.panic.index')}}" class="waves-effect">
                            <i class="fa fa-exclamation-triangle"></i><span> Laporan Panic Button </span>
                        </a>
                    </li>
                    @endcan
                @elseif(Auth::user()->role == 5 || Auth::user()->role == 6)
                <li class="menu-title">Menu</li>
                    <li>
                        <a href="{{route('dinas.dashboard')}}" class="waves-effect">
                            <i class="icon-accelerator"></i><span> Dashboard </span>
                        </a>

                    </li>

                    <li>
                        <a href="{{route('dinas.index')}}" class="waves-effect">
                            <i class="fas fa-users"></i><span> Data Pasien </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('dinas.pasien.positif')}}" class="waves-effect">
                            <i class="fas fa-file-medical-alt"></i><span> Catatan Pasien </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route ('admin.auth.change_password') }}" class="waves-effect">
                            <i class="mdi mdi-account-key-outline"></i><span> Ubah Password </span>
                        </a>
                    </li>
                @else
                <li class="menu-title">Menu</li>
                <li>
                    <a href="{{route('admin.index')}}" class="waves-effect">
                        <i class="icon-accelerator"></i><span> Dashboard </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.peta')}}" target="_blank" class="waves-effect">
                        <i class="icon-map"></i><span> Peta Sebaran </span>
                    </a>
                </li>
                
                <li>
                    <a href="{{route('admin.pasien.panic')}}" class="waves-effect">
                        <i class="mdi mdi-alarm-light-outline"></i><span> Laporan Panic Pasien </span>
                    </a>
                </li>

                

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span> Data Pasien <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        @can('can_petugas')
                        <li><a href="{{ route ('admin.pasien.index') }}"> Pasien Anda </a></li>
                        @endcan
                        <li><a href="{{ route ('admin.pasien.petugas') }}"> Semua Pasien </a></li>
                        <li><a href="{{ route ('admin.pasien.laporan') }}"> Catatan Pasien </a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route ('admin.distance.index') }}">
                        <i class="mdi mdi-map-marker-distance"></i><span> Physical Distancing </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route ('admin.posko.index') }}" class="waves-effect">
                        <i class="mdi mdi-tent"></i><span> Posko </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route ('admin.rumah_sakit.index') }}" class="waves-effect">
                        <i class="mdi mdi-hospital"></i><span> Rumah Sakit </span>
                    </a>
                </li>

                {{-- <li>
                    <a href="{{ route ('admin.dpt.index') }}" class="waves-effect2">
                        <i class="icon-profile"></i><span> DPT </span>
                    </a>
                </li> --}}


                @can('can_super_admin')
                <li>
                    <a href="{{ route ('admin.jenis_kasus.index') }}" class="waves-effect">
                        <i class="mdi mdi-format-list-bulleted-type"></i><span> Jenis Kasus </span>
                    </a>
                </li>
                @endcan

                @canany(['can_admin', 'can_super_admin'])
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi  mdi-map-legend"></i><span> Wilayah <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="{{ route ('admin.kecamatan.index') }}"> Kecamatan </a></li>
                        <li><a href="{{ route ('admin.kelurahan.index') }}"> Kelurahan </a></li>
                    </ul>
                </li>
                @endcanany

                @canany(['can_admin', 'can_super_admin'])
                <li>
                    <a href="{{ route ('admin.petugas.history') }}" class="waves-effect">
                        <i class="mdi mdi-history"></i><span> Riwayat Petugas </span>
                    </a>
                </li>
                @endcanany 

                @canany(['can_admin', 'can_super_admin'])
                <li>
                    <a href="{{ route ('admin.user.index') }}" class="waves-effect">
                        <i class="mdi mdi-account-group"></i><span> Data Pengguna </span>
                    </a>
                </li>
		<li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="fab fa-expeditedssl"></i><span> Data Napi <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        @can('can_admin')
                        <li><a href="{{ route ('admin.napi.index') }}"> Tambah Narapidana </a></li>
                        @endcan
                        <li><a href="{{ route ('admin.napi.all') }}"> Semua Narapidana </a></li>
                    </ul>
                </li>
                @endcanany

                <li>
                    <a href="{{ route ('admin.auth.change_password') }}" class="waves-effect">
                        <i class="mdi mdi-account-key-outline"></i><span> Ubah Password </span>
                    </a>
                </li>
                @endif
            </ul>
        </div>

        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->