<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
use App\Kelurahan;
use App\Kecamatan;
use Auth;
use MPDF;

class PrintPdfController extends Controller
{
    // public function __construct()
    // {
    // 	return $this->middleware('auth');
    // }

    public function print_pdf_pasien_per_kecmatan(Request $request, $kecamatan_id)
    {
    	$pasien = Pasien::join('kelurahans as kel', 'pasiens.kelurahan_id', '=', 'kel.id')
                        ->with('jenis_kasus')
                        ->join('kecamatans as kec', 'kel.kecamatan_id', '=', 'kec.id')
                        ->select('pasiens.jenis_isolasi','pasiens.alamat_sekarang', 'pasiens.jenis_kelamin as jk', 'pasiens.lat', 'pasiens.lng', 'pasiens.usia', 'pasiens.jenis_kasus_id', 'kec.id as kec_id', 'kel.id as kel_id', 'kec.nama as kec_nama', 'kel.nama as kel_nama', 'pasiens.nama', 'pasiens.nik', 'pasiens.status')
                        ->where('kel.kecamatan_id', $kecamatan_id)
                        ->get();

        $nama_kecamatan = Kecamatan::select('nama')->where('id', $kecamatan_id)->first()->nama;
        
        //return $pasien;
        
        $nama_file = "Rekap Data Pasien Covid-19 Kecamatan " .$nama_kecamatan. ", Sidoarjo";
        $format_file = ".pdf";

        $pdf = MPDF::loadView('admin.cetak_pdf.pasien_kecamatan', ['pasien'=>$pasien, 'nama_kecamatan'=>$nama_kecamatan]);

        return $pdf->stream($nama_file.$format_file);
    }
}
