<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Pasien;
use App\Panic;
use App\Posko;

class PanicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $panic = new Panic;
        $panic->pasien_id = Pasien::select('id')->where('user_id', Auth::user()->id)->first()->id;
        $panic->kelurahan_id = Pasien::select('kelurahan_id')->where('user_id', Auth::user()->id)->first()->kelurahan_id;
        $panic->status = 0;

        $panic->save();

        alert()->success('Laporan anda telah berhasil diterima oleh posko terdekat, tim kami akan menindak lanjutinya', 'Mohon Ditunggu!')->autoclose('9000');
            return back();
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
