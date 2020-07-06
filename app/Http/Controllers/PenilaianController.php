<?php

namespace App\Http\Controllers;

use App\Penilaian;
use App\Rundown;
use Auth;
use App\User;
use Alert;
use Image;
use Storage;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pasien.index');
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
        $rundown = Rundown::get();
        $dateNow = date("Y-m-d");

        if (Penilaian::where('tanggal', $dateNow)->where('user_id', Auth::user()->id)->exists()) {
            return redirect()->back()->with(['errors' => 'Maaf Anda telah melakukan inisiasi assesment pada tanggal ini, silahkan menuju menu Active Assesment.']);
        }
        else{
            foreach ($rundown->toArray() as $rundwn) {
                
                $data[] = array(
                    'user_id' => Auth::user()->id,
                    'rundown_id' => $rundwn['id'],
                    'tanggal' => $dateNow,
                );
            }

            foreach ($data as $data_val) {
                Penilaian::insert($data_val);
            }

            return redirect()->back()->with(['success' => 'Selamat Assesment kesehatan anda pada tanggal']);
        }
    }

    public function penilaian1(Request $request)
    {
        $dataNilai = array(
            'keterangan' => $request->nilai1 +  $request->nilai2 +  $request->nilai3 +  $request->nilai4 +  $request->nilai5 +  $request->nilai6,
            'status' => 1,
        );

        $suhu = array(
            'keterangan' => $request->suhu,
            'status' => 1,
        );

        Penilaian::where('rundown_id', 1)->where('user_id', Auth::user()->id)->update($dataNilai);
        Penilaian::where('rundown_id', 2)->where('user_id', Auth::user()->id)->update($suhu);
        
        $nilai = $dataNilai['keterangan'];
        if($nilai > 2) {
            $status = "Periksakan";
        }
        else if($nilai > 0 && $nilai <=2) {
            $status = "Waspada";
        }
        else if($nilai == 0){
            $status = "Normal";
        }
        
        alert()->success('Laporan/ penilaian Anda untuk langkah Deteksi Dini telah berhasil terekam. Status anda '.$status. ' ,Silahkan lanjutkan untuk langkah kedua berikut', 'Sukses!')->autoclose('9000');
            return redirect()->route('pasien.penilaian2.index');
    }

    public function penilaian2(Request $request, $id)
    {   
        if ($request->has('images')) {
            $file = $request->file('images');
            $fileName = time().'-'.$file->getClientOriginalName();
            $destinationPath = public_path('laporan/penilaian/' .$fileName);

            Image::make($file->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath);
        }

        $data = array(
            'keterangan' => $request->keterangan,
            'foto' => $fileName,
            'status' => 1,
        );

        $jam = Penilaian::where('id', $id)->first();

        Penilaian::where('id', $id)->update($data);

        alert()->success('Laporan/ penilaian Anda untuk rundwon jam' .$jam->rundown->jam. ' telah berhasil di update', 'Sukses!')->autoclose('9000');
            return back();
    }

    public function beriNilai2()
    {   
        $dateNow = date("Y-m-d");
        if (Penilaian::select('keterangan')->where('tanggal', $dateNow)->where('user_id', Auth::user()->id)->where('rundown_id',1)->first()->keterangan == NULL) {
            
            alert()->warning('Anda belum menyelesaikan laporan deteksi dini. Segera selesaikan, untuk dapat mengakses menu laporan kegiatan', 'Informasi!')->autoclose('9000');
            return redirect()->route('pasien.penilaian1.index');
        }
        else {
            
            $rundown = Penilaian::where('tanggal', $dateNow)->where('user_id', Auth::user()->id)->where('rundown_id','!=', 1)->where('rundown_id', '!=', 2)->get();

            return view('pasien.penilaian.upload', compact('rundown'));
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function show(Penilaian $penilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function beriNilai1()
    {   
        // $dateNow = date("Y-m-d");
        // $penilaian = Penilaian::where('tanggal', $dateNow)->where('user_id', Auth::user()->id)->get();

        return view('pasien.penilaian.index', compact('penilaian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penilaian $penilaian)
    {
        //
    }
}
