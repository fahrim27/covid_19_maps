<?php

namespace App\Http\Controllers;

use App\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Kecamatan;
use Validator;

class KelurahanController extends Controller
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
        
        $getAllKelurahan = Kelurahan::orderBy('nama', 'asc')->paginate(25);
        $kecamatan = Kecamatan::orderBy('nama', 'asc')->get();

        return view('admin.wilayah.kelurahan', compact('getAllKelurahan', 'kecamatan'));
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
            'kecamatan_id' => 'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Kelurahan tidak boleh dikosongi.',
                'kecamatan_id.required' => 'Maaf, Nama Kecamatan tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'nama'   =>  $request->nama,
            'kecamatan_id' => $request->kecamatan_id,
        );

        $kelurahan = Kelurahan::create($input_data);

        return redirect()->back()->with(['success' => 'Data Kelurahan ' .$request->nama. ' Berhasil Ditambahkan.']);
    }

    /**
     * Display the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function show(Kelurahan $kelurahan)
    {
        $kelurahan::findOrFail($kelurahan->id);

        //return view('kabupatenKota.show', compact('kabupatenKota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelurahan $kelurahan)
    {
        $data = Kelurahan::where('id', $kelurahan->id)->first();
 
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
            'kecamatan_id' => 'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Kelurahan tidak boleh dikosongi.',
                'kecamatan_id.required' => 'Maaf, Nama Kecamatan tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'nama'         => $request->nama,
            'kecamatan_id' => $request->kecamatan_id,
        );

        Kelurahan::whereId($request->id)->update($input_data);

        return redirect()->back()->with(['success' => 'Data Kelurahan ' .$request->nama. ' Berhasil di Update.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelurahan $kelurahan)
    {
        $kelurahan->delete();

        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
