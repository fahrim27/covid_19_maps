<?php

namespace App\Http\Controllers;

use App\RumahSakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Kelurahan;
use App\Kecamatan;
use Validator;

class RumahSakitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if (Gate::allows('can_pasien')) {
            return abort(401);
        }
        if (Gate::allows('can_posko')) {
            return abort(401);
        }
        
        $getAllRS = RumahSakit::get();
        $kecamatan = Kecamatan::get();

        return view('admin.rumah_sakit.index', compact('getAllRS', 'kecamatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $kelurahan = Kelurahan::get();

        // return view('admin.posko.create', compact('kelurahan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if (! Gate::allows('can_petugas')) {
             return abort(401);
        }

        $rules = array(
            'nama'       =>  'required',
            'no_hp'      =>  'required',
            'jumlah'     =>  'required',
            'kelurahan_id2' => 'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Rumah Sakit tidak boleh dikosongi.',
                'no_hp.required' => 'Maaf, No. Rumah Sakit tidak boleh dikosongi.',
                'jumlah.required' => 'Maaf, jumlah tidak boleh dikosongi.',
                'kelurahan_id2.required' => 'Maaf, Nama Kelurahan tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }
        
        if($request->has('select_kelurahan'))
        {
            $lat = Kelurahan::select('lat')->where('id', $request->kelurahan_id2)->first()->lat;
            $lng = Kelurahan::select('lng')->where('id', $request->kelurahan_id2)->first()->lng;
        }
        else
        {
            if (count($request->latSearch) > 0) {
                $lat = $request->latSearch[count($request->latSearch) - 1];
                $lng = $request->lngSearch[count($request->lngSearch) - 1];
            }
            else if (count($request->latSearch) < 0){
                $lat = $request->latSearch[0];
                $lng = $request->lngSearch[0];
            }
        }

        $input_data = array(
            'nama'   =>  $request->nama,
            'kelurahan_id' => $request->kelurahan_id2,
            'jumlah'    => $request->jumlah,
            'no_hp'     => $request->no_hp,
            'lat'  => $lat,
            'lng'  => $lng,
        );

        $rumah_sakit = RumahSakit::create($input_data);

        return redirect()->back()->with(['success' => 'Data Rumah Sakit ' .$request->nama. ' Berhasil Ditambahkan.']);
    }

    /**
     * Display the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function show(RumahSakit $rumah_sakit)
    {
        $data = RumahSakit::where('id', $rumah_sakit->id)->first();
 
        return response()->json(["data" => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function edit(RumahSakit $rumah_sakit)
    {   
        if (! Gate::allows('can_petugas')) {
             return abort(401);
        }

        $data = RumahSakit::where('id', $rumah_sakit->id)->first();
 
        return response()->json(["data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        if (! Gate::allows('can_petugas')) {
             return abort(401);
        }

        $rules = array(
            'nama'       =>  'required',
            'no_hp'      =>  'required',
            'jumlah'     =>  'required',
            'kelurahan_id' => 'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Rumah Sakit tidak boleh dikosongi.',
                'no_hp.required' => 'Maaf, No. Rumah Sakit tidak boleh dikosongi.',
                'jumlah.required' => 'Maaf, jumlah tidak boleh dikosongi.',
                'kelurahan_id.required' => 'Maaf, Nama Kelurahan tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'nama'   =>  $request->nama,
            'kelurahan_id' => $request->kelurahan_id,
            'jumlah'    => $request->jumlah,
            'no_hp'     => $request->no_hp,
        );

        RumahSakit::whereId($request->id)->update($input_data);

        return redirect()->back()->with(['success' => 'Data Rumah Sakit ' .$request->nama. ' Berhasil di Update.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function destroy(RumahSakit $rumah_sakit)
    {   
        if (! Gate::allows('can_petugas')) {
             return abort(401);
        }
        
        $rumah_sakit->delete();

        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
