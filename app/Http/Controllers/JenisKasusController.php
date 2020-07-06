<?php

namespace App\Http\Controllers;

use App\JenisKasus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Validator;

class JenisKasusController extends Controller
{
    // public function __construct()
    // {
    //     if (! Gate::allows('can_all')) {
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
        if (! Gate::allows('can_super_admin')) {
            return abort(401);
        }
        if (Gate::allows('can_pasien')) {
            return abort(401);
        }
        if (Gate::allows('can_posko')) {
            return abort(401);
        }
        
        $getAllJenisKasus = JenisKasus::orderBy('nama', 'asc')->paginate(25);

        return view('admin.jenis_kasus.index', compact('getAllJenisKasus'));
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
                'nama.required' => 'Maaf, Nama Jenis Kasus tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'nama'   =>  $request->nama,
        );

        $jenis_kasus = JenisKasus::create($input_data);

        return redirect()->back()->with(['success' => 'Data Jenis Kasus degan nama ' .$request->nama. ' Berhasil Ditambahkan.']);
    }

    /**
     * Display the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function show(JenisKasus $jenis_kasus)
    {
        $jenis_kasus::findOrFail($jenis_kasus->id);

        //return view('kabupatenKota.show', compact('kabupatenKota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisKasus $jenis_kasus)
    {
        $data = JenisKasus::where('id', $jenis_kasus->id)->first();
 
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
                'nama.required' => 'Maaf, Nama Jenis Kasus tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'nama'              =>  $request->nama,
        );

        JenisKasus::whereId($request->id)->update($input_data);

        return redirect()->back()->with(['Data Jenis Kasus degan nama ' .$request->nama. ' Berhasil Diupdate.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisKasus $jenis_kasus)
    {
        $jenis_kasus->delete();

        return response()->json(['success' => 'Data Jenis Kasus Berhasil Dihapus.']);
    }
}
