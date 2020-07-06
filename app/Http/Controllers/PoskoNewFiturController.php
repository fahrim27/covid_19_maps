<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posko;
use App\Pasien;
use App\Panic;
use DB;
use Auth;

class PoskoNewFiturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->nrp;

        $idPosko = explode("-", $user);
        $kelurahan_id = Posko::select('kelurahan_id')->where('id', $idPosko[1])->first()->kelurahan_id;

        $pasienPositif = Pasien::where('kelurahan_id', $kelurahan_id)->where('jenis_kasus_id', 1)->get();
        
        $pasien = Pasien::join('kelurahans as kel', 'pasiens.kelurahan_id', '=', 'kel.id')
                        ->with('jenis_kasus')
                        ->join('kecamatans as kec', 'kel.kecamatan_id', '=', 'kec.id')
                        ->select('pasiens.nama','pasiens.jenis_isolasi','pasiens.jenis_kelamin as jk', 'pasiens.lat', 'pasiens.lng', 'pasiens.usia', 'pasiens.jenis_kasus_id', 'pasiens.jenis_kasus_id as status', 'kec.id as kec_id', 'kel.id as kel_id', 'kec.nama as kec_nama', 'kel.nama as kel_nama', 'pasiens.status as s')
                        ->where('kel.id', $kelurahan_id)
                        ->where('pasiens.jenis_kasus_id', 1)
                        ->get();
        
        return view('posko.index', [
            'pasien' => $pasien
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPasienPosko()
    {
        $user = Auth::user()->nrp;

        $idPosko = explode("-", $user);
        $kelurahan_id = Posko::select('kelurahan_id')->where('id', $idPosko[1])->first()->kelurahan_id;

        $pasienPositif = Pasien::where('kelurahan_id', $kelurahan_id)->where('jenis_kasus_id', 1)->get();

        return view('posko.pasien', compact('pasienPositif'));
    }

    public function setIntervalPasien()
    {
        $user = Auth::user()->nrp;

        $idPosko = explode("-", $user);
        $kelurahan_id = Posko::select('kelurahan_id')->where('id', $idPosko[1])->first()->kelurahan_id;

        $pasienPositif = Pasien::where('kelurahan_id', $kelurahan_id)->where('jenis_kasus_id', 1)->get();

        return view('posko.ajaxReload', compact('pasienPositif'));   
    }
    
    public function waPasien(Request $request, $id)
    {
        $pasien = Pasien::find($id);
        
        $pasien->nik = $request->wa;
        $pasien->save();
        
        alert()->success('Nomer Wa Pasien, '.$pasien->nama.' Telah Berhasil di Tambahkan', 'Sukses!')->persistent('Close');
        return back();
    }
    
    public function panicIndex()
    {
        $posko_id = DB::table('posko_user')->where('user_id', Auth::user()->id)->first();
        $posko = Posko::where('id', $posko_id->posko_id)->first();
        
        $panic = Panic::where('kelurahan_id', $posko->kelurahan_id)->orderBy('created_at', 'desc')->limit(20)->get();
        
        return view('posko.panic_index', compact('panic'));
    }
    
    public function panicUpdateStatus(Request $request)
    {
        $input_data = array(
            'status'   =>  1,
        );

        \DB::table('panic')->where('id', $request->id_panic)->update($input_data);
        
        alert()->success('Laporan Pasien telah berhasil diterima. Silahkan untuk menindaklanjuti', 'Sukses!')->persistent('Close');
        return back();
    }
    
    public function setIntervalPanic()
    {
        $posko_id = DB::table('posko_user')->where('user_id', Auth::user()->id)->first();
        $posko = Posko::where('id', $posko_id->posko_id)->first();
        
        $panic = Panic::where('kelurahan_id', $posko->kelurahan_id)->orderBy('created_at', 'desc')->limit(20)->get();
        
        return view('posko.panic_index_ajax', compact('panic'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
