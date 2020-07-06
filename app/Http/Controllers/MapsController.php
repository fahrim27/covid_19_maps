<?php

namespace App\Http\Controllers;

use App\Distance;
use App\JenisKasus;
use App\Kecamatan;
use App\Pasien;
use App\Posko;
use App\RumahSakit;
use App\Napi;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function __construct(){
        return $this->middleware('auth')->except('maps');
    }
    
    public function maps(){
        $kategori = JenisKasus::get();
        $kecamatan = Kecamatan::get();

        $kecamatan->map(function($q){
            $q['positif'] = 0;
            $q['odp'] = 0;
            $q['pdp'] = 0;
            $q['rs'] = 0;
            $q['posko'] = 0;
            $q['pd'] = 0;
            $q['sembuh'] = 0;
            $q['meninggal'] = 0;
        });

        $pasien = Pasien::join('kelurahans as kel', 'pasiens.kelurahan_id', '=', 'kel.id')
                        ->with('jenis_kasus')
                        ->join('kecamatans as kec', 'kel.kecamatan_id', '=', 'kec.id')
                        ->select('pasiens.nama','pasiens.jenis_isolasi','pasiens.jenis_kelamin as jk', 'pasiens.lat', 'pasiens.lng', 'pasiens.usia', 'pasiens.jenis_kasus_id', 'pasiens.jenis_kasus_id as status', 'kec.id as kec_id', 'kel.id as kel_id', 'kec.nama as kec_nama', 'kel.nama as kel_nama', 'pasiens.status as s')
                        ->get();
        
        $rs = RumahSakit::join('kelurahans as kel', 'rumah_sakits.kelurahan_id', '=', 'kel.id')
                        ->join('kecamatans as kec', 'kel.kecamatan_id', '=', 'kec.id')
                        ->select('rumah_sakits.*', 'kec.id as kec_id', 'kel.id as kel_id', 'kec.nama as kec_nama', 'kel.nama as kel_nama')
                        ->get();

        $pd = Distance::join('kelurahans as kel', 'distances.kelurahan_id', '=', 'kel.id')
                        ->join('kecamatans as kec', 'kel.kecamatan_id', '=', 'kec.id')
                        ->select('distances.*', 'kec.id as kec_id', 'kel.id as kel_id', 'kec.nama as kec_nama', 'kel.nama as kel_nama')
                        ->get();
                        
        $posko = Posko::join('kelurahans as kel', 'poskos.kelurahan_id', '=', 'kel.id')
                        ->join('kecamatans as kec', 'kel.kecamatan_id', '=', 'kec.id')
                        ->select('poskos.*', 'kec.id as kec_id', 'kel.id as kel_id', 'kec.nama as kec_nama', 'kel.nama as kel_nama')
                        ->get();

        return view('masyarakat.maps', [
            'kategori' => $kategori,
            'kecamatan' => $kecamatan,
            'pasien' => $pasien,
            'rs' => $rs,
            'pd' => $pd,
            'posko' => $posko
        ]);
    }
    
    public function polisi(){
        $kategori = JenisKasus::get();
        $kecamatan = Kecamatan::get();

        $kecamatan->map(function($q){
            $q['positif'] = 0;
            $q['odp'] = 0;
            $q['pdp'] = 0;
            $q['rs'] = 0;
            $q['posko'] = 0;
            $q['pd'] = 0;
            $q['sembuh'] = 0;
            $q['meninggal'] = 0;
            $q['napi'] = 0;
            $q['petugas'] = 0;
        });

        $pasien = Pasien::join('kelurahans as kel', 'pasiens.kelurahan_id', '=', 'kel.id')
                        ->with('jenis_kasus')
                        ->join('kecamatans as kec', 'kel.kecamatan_id', '=', 'kec.id')
                        ->select('pasiens.nik as no','pasiens.nama','pasiens.jenis_isolasi','pasiens.jenis_kelamin as jk', 'pasiens.lat', 'pasiens.lng', 'pasiens.usia', 'pasiens.jenis_kasus_id', 'pasiens.jenis_kasus_id as status', 'kec.id as kec_id', 'kel.id as kel_id', 'kec.nama as kec_nama', 'kel.nama as kel_nama', 'pasiens.status as s')
                        ->get();
        
        $rs = RumahSakit::join('kelurahans as kel', 'rumah_sakits.kelurahan_id', '=', 'kel.id')
                        ->join('kecamatans as kec', 'kel.kecamatan_id', '=', 'kec.id')
                        ->select('rumah_sakits.*', 'kec.id as kec_id', 'kel.id as kel_id', 'kec.nama as kec_nama', 'kel.nama as kel_nama')
                        ->get();

        $pd = Distance::join('kelurahans as kel', 'distances.kelurahan_id', '=', 'kel.id')
                        ->join('kecamatans as kec', 'kel.kecamatan_id', '=', 'kec.id')
                        ->select('distances.*', 'kec.id as kec_id', 'kel.id as kel_id', 'kec.nama as kec_nama', 'kel.nama as kel_nama')
                        ->get();
                        
        $posko = Posko::join('kelurahans as kel', 'poskos.kelurahan_id', '=', 'kel.id')
                        ->join('kecamatans as kec', 'kel.kecamatan_id', '=', 'kec.id')
                        ->select('poskos.*', 'kec.id as kec_id', 'kel.id as kel_id', 'kec.nama as kec_nama', 'kel.nama as kel_nama')
                        ->get();
        
        $napi = Napi::join('kelurahans as kel', 'napis.kelurahan_id', '=', 'kel.id')
                        ->join('kecamatans as kec', 'kel.kecamatan_id', '=', 'kec.id')
                        ->select('napis.*', 'kec.id as kec_id', 'kel.id as kel_id', 'kec.nama as kec_nama', 'kel.nama as kel_nama')
                        ->get();

        return view('admin.maps', [
            'kategori' => $kategori,
            'kecamatan' => $kecamatan,
            'pasien' => $pasien,
            'rs' => $rs,
            'pd' => $pd,
            'posko' => $posko,
            'napi' => $napi
        ]);
    }
}
