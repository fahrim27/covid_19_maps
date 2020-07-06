<?php

namespace App\Http\Controllers;

use App\Posko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Kelurahan;
use App\Kecamatan;
use Validator;

class PoskoController extends Controller
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
        
        $getAllPosko = Posko::get();
        $kecamatan = Kecamatan::get();

        return view('admin.posko.index', compact('getAllPosko', 'kecamatan'));
    }

    public function getKelurahan(Request $request)
        {
            $kelurahan = Kelurahan::where('kecamatan_id', $request->kecamatan_id)->pluck("nama","id");;
            return response()->json($kelurahan);
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
            'kelurahan_id2' => 'required',
            'wa' => 'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Posko tidak boleh dikosongi.',
                'wa.required' => 'Maaf, No. Telpon Posko tidak boleh dikosongi.',
                'kelurahan_id2.required' => 'Maaf, Nama Kelurahan tidak boleh dikosongi.',
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
            'nama'   =>  $request->nama,
            'kelurahan_id' => $request->kelurahan_id2,
            'lat'  => $lat,
            'lng'  => $lng,
            'phone' => $request->wa,
        );

        $Posko = Posko::create($input_data);

        return redirect()->back()->with(['success' => 'Data Posko ' .$request->nama. ' Berhasil Ditambahkan.']);
    }

    /**
     * Display the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function show(Posko $posko)
    {
        $data = Posko::where('id', $posko->id)->first();
 
        return response()->json(["data" => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function edit(Posko $posko)
    {   
        $data = Posko::where('id', $posko->id)->first();
 
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
            'kelurahan_id' => 'required',
            'wa' => 'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Posko tidak boleh dikosongi.',
                'kelurahan_id.required' => 'Maaf, Nama Kelurahan tidak boleh dikosongi.',
                'wa.required' => 'Maaf, No. Telpon Posko tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'nama'   =>  $request->nama,
            'kelurahan_id' => $request->kelurahan_id,
            'phone' => $request->wa,
        );

        Posko::whereId($request->id)->update($input_data);

        return redirect()->back()->with(['success' => 'Data Posko ' .$request->nama. ' Berhasil di Update.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posko $posko)
    {   
        if (! Gate::allows('can_petugas')) {
             return abort(401);
        }
        
        $posko->delete();

        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
