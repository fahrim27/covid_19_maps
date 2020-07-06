<?php

namespace App\Http\Controllers;

use App\Napi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Kelurahan;
use App\Kecamatan;
use App\User;
use App\Pasien;
use Validator;
use Auth;

class NapiController extends Controller
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
        
        $getAllNapibyPetugas = Napi::where('petugas_id', Auth::user()->id)->get();
        $kecamatan = Kecamatan::get();

        return view('admin.napi.petugas', compact('getAllNapibyPetugas', 'kecamatan'));
    }

    public function indexAll()
    {
        $getAllNapi = Napi::get();

        return view('admin.napi.index', compact('getAllNapi'));
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
        $rules = array(
            'nama'       =>  'required',
            'kelurahan_id2'       =>  'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Napi tidak boleh dikosongi.',
                'kelurahan_id2.required' => 'Maaf, Kelurahan Napi tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        //return $request->all();
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
            'petugas_id'    => Auth::user()->id,
            'nama'   =>  $request->nama,
            'kelurahan_id' => $request->kelurahan_id2,
            'lat'  => $lat,
            'lng'  => $lng,
        );

        $napi = Napi::create($input_data);

        return redirect()->back()->with(['success' => 'Data Napi dengan nama ' .$request->nama. ', Berhasil Ditambahkan.']);
    }

    /**
     * Display the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function show(Napi $napi)
    {
        $data = Napi::where('id', $napi->id)->first();
        $nama = User::select('name')->where('id', $napi->petugas_id)->first()->name;
        $nrp = User::select('nrp')->where('id', $napi->petugas_id)->first()->nrp;
 
        return response()->json(["data" => $data, "nama" => $nama, "nrp" => $nrp]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function edit(Napi $napi)
    {
        $data = Napi::where('id', $napi->id)->first();
 
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
        $rules = array(
            'nama'       =>  'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Pasien tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }
        
        $input_data = array(
            'petugas_id'    => Auth::user()->id,
            'nama'   =>  $request->nama,
            'kelurahan_id' => $request->kelurahan_id,
        );

        Napi::whereId($request->id)->update($input_data);

        return redirect()->back()->with(['success' => 'Data Napi dengan nama ' .$request->nama. ', Berhasil Diupdate.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Napi $napi)
    {
        $napi->delete();

        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
