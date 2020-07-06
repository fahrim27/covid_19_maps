<?php

namespace App\Http\Controllers;

use App\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Validator;

class KecamatanController extends Controller
{   
    // public function __construct()
    // {
    //     if (! Gate::allows('can_admin')) {
    //         return abort(401);
    //     }
    // }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if (Gate::allows('can_petugas')) {
             return abort(401);
        }
        if (Gate::allows('can_pasien')) {
            return abort(401);
        }
        if (Gate::allows('can_posko')) {
            return abort(401);
        }

        $getAllKecamatan = Kecamatan::orderBy('nama', 'asc')->paginate(25);

        return view('admin.wilayah.kecamatan', compact('getAllKecamatan'));
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
        $rules = array(
            'nama'       =>  'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Kecamatan tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'nama'   =>  $request->nama,
        );

        $kecamatan = Kecamatan::create($input_data);

        $id = Kecamatan::select('id')->where('id', $kecamatan->id)->first()->id;

        return redirect()->back()->with(['success' => 'Data Kecamatan ' .$request->nama. ' Berhasil Ditambahkan.']);
    }

    /**
     * Display the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function show(Kecamatan $kecamatan)
    {
        $kecamatan::findOrFail($kecamatan->id);

        //return view('kabupatenKota.show', compact('kabupatenKota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function edit(Kecamatan $kecamatan)
    {
        $data = Kecamatan::where('id', $kecamatan->id)->first();
 
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
                'nama.required' => 'Maaf, Nama Kecamatan tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'nama'              =>  $request->nama,
        );

        Kecamatan::whereId($request->id)->update($input_data);

        return redirect()->back()->with(['success' => 'Data Kecamatan ' .$request->nama. ' Berhasil Diupdate.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return response()->json(['success' => 'DataKecamatan Berhasil Dihapus.']);
    }
}
