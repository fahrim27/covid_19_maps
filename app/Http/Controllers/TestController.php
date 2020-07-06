<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Pasien;
use App\Test;
use Auth;
use Validator;

class TestController extends Controller
{   
    private $pasien_id;

    public function __construct()
    {   
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pasien_id = Pasien::select('id')->where('user_id', Auth::user()->id)->first()->id;

        $test = Test::where('pasien_id', $pasien_id)->get();

        return view('pasien.test.index', compact('test', 'pasien_id'));
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
            'tgl_tes'       =>  'required',
        );

        $messages = array(
                'tgl_tes.required' => 'Maaf, Tanggal test tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {   
            alert()->error('Tanggal test tidak boleh dikosongi.', 'Gagal!')->autoclose('3000');
            return back();
        }

        $input_data = array(
            'jenis_tes'   =>  $request->jenis_tes.' Test '.$request->tes_ke,
            'pasien_id' => $request->pasien_id,
            'tgl_tes'  => $request->tgl_tes,
            'tgl_hasil_tes' => $request->tgl_hasil_tes,
            'keterangan' => $request->keterangan,
        );

        Test::create($input_data);

        alert()->success('Catatan test '.$request->jenis_tes.' anda telah berhasil terekam.', 'Sukses!')->autoclose('6000');
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
        $pasien_id = Pasien::select('id')->where('user_id', Auth::user()->id)->first()->id;
        $data = Test::where('id', $id)->where('pasien_id', $pasien_id)->first();
 
        return response()->json(["data" => $data]);
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
        $rules = array(
            'tgl_hasil_tes'       =>  'required',
            'keterangan'       =>  'required',
        );

        $messages = array(
                'tgl_hasil_tes.required' => 'Maaf, Tanggal hasil test tidak boleh dikosongi.',
                'keterangan.required' => 'Maaf, Keterangan hasil test tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'keterangan' => $request->keterangan,
            'tgl_hasil_tes' => $request->tgl_hasil_tes,
        );

        if($request->hasFIle('foto')){

            $file = $request->file('foto');
            $fileName = time().'.'.$file->getClientOriginalName();
            $ServicesPath = public_path('/hasil_test');
            $file->move($ServicesPath, $fileName);

            $foto = array(
                'foto', $fileName,
            );

            $new_data = array_merge($input_data, $foto);

            Test::whereId($id)->update($new_data);
        }
        else{

            Test::whereId($id)->update($input_data);
        }

        alert()->success('Catatan hasil test '.$request->jenis_tes.' anda telah berhasil terekam.', 'Sukses!')->autoclose('6000');
        return back();
    }

    public function update_test2(Request $request, $id)
    {
        $rules = array(
            'tgl_hasil_tes'       =>  'required',
            'keterangan'       =>  'required',
        );

        $messages = array(
                'tgl_hasil_tes.required' => 'Maaf, Tanggal hasil test tidak boleh dikosongi.',
                'keterangan.required' => 'Maaf, Keterangan hasil test tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'keterangan' => $request->keterangan,
            'tgl_hasil_tes' => $request->tgl_hasil_tes,
        );

        if($request->hasFIle('foto')){

            $file = $request->file('foto');
            $fileName = time().'.'.$file->getClientOriginalName();
            $ServicesPath = public_path('/hasil_test');
            $file->move($ServicesPath, $fileName);

            $foto = array(
                'foto', $fileName,
            );

            $new_data = array_merge($input_data, $foto);

            Test::whereId($id)->update($new_data);
        }
        else{

            Test::whereId($id)->update($input_data);
        }

        alert()->success('Catatan hasil test '.$request->jenis_tes.' anda telah berhasil terekam.', 'Sukses!')->autoclose('6000');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $pasien_id = Pasien::select('id')->where('user_id', Auth::user()->id)->first()->id;
        Test::where('id', $id)->where('pasien_id', $pasien_id)->delete();

        alert()->warning('Catatan test '.$request->jenis_tes.' anda telah berhasil di hapus.', 'Sukses!')->autoclose('6000');
        return back();
    }
    
    public function getFilteredResults(Request $request)
    {
        if($request->str != "")
        {
            $dataPasien = Pasien::where('nama', 'Like', '%'.$request->str.'%')->take(7)->get();
            
            return view('admin.pasien.pasienPositf_ajaxSearch', compact('dataPasien'));
        }
    }
    
    public function get_filtered_by_kel(Request $request)
    {   
        if($request->session()->has('kel_id')){
			$request->session()->forget('kel_id');
		}
		
		$request->session()->put('kel_id', $request->filBy);
		
        if($request->filBy != null)
        {
            $dataPasien = Pasien::where('kelurahan_id', $request->filBy)->where('jenis_kasus_id', 1)->get();
            
            return view('admin.pasien.pasienPositf_ajaxSearch', compact('dataPasien'));
        }
    }
}
