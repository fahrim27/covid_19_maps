<?php

namespace App\Http\Controllers;

use App\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Kelurahan;
use App\Kecamatan;
use App\JenisKasus;
use App\User;
use App\Panic;
use App\Penilaian;
use Validator;
use Auth;
use DB;

class PasienController extends Controller
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
        
        $getAllPasienbyPetugas = Pasien::where('petugas_id', Auth::user()->id)->get();
        $kecamatan = Kecamatan::get();
        $jenis_kasus = JenisKasus::get();

        return view('admin.pasien.petugas', compact('getAllPasienbyPetugas', 'kecamatan', 'jenis_kasus'));
    }

    public function indexByPetugas()
    {
        $getAllPasien = Pasien::get();

        return view('admin.pasien.index', compact('getAllPasien'));
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
            'alamat_ktp'       =>  'required',
            'alamat_sekarang'       =>  'required',
            'usia'       =>  'required',
            'jenis_kelamin'       =>  'required',
            'jenis_kasus'       =>  'required',
            'jenis_isolasi'       =>  'required',
            'kelurahan_id2'       =>  'required',
            'status'              =>  'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Pasien tidak boleh dikosongi.',
                'alamat_ktp.required' => 'Maaf, Alamat KTP Pasien tidak boleh dikosongi.',
                'alamat_sekarang.required' => 'Maaf, Alamat Tinggal Pasien tidak boleh dikosongi.',
                'usia.required' => 'Maaf, Usia Pasien tidak boleh dikosongi.',
                'jenis_kelamin.required' => 'Maaf, Jenis Kelamin Pasien tidak boleh dikosongi.',
                'jenis_kasus.required' => 'Maaf, Jenis Kasus Pasien tidak boleh dikosongi.',
                'jenis_isolasi.required' => 'Maaf, Jenis Isolasi Pasien tidak boleh dikosongi.',
                'kelurahan_id2.required' => 'Maaf, Kelurahan Pasien tidak boleh dikosongi.',
                'status.required' => 'Maaf, Status Pasien tidak boleh dikosongi.',
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
            'nik'    => $request->nik,
            'alamat_ktp'     => $request->alamat_ktp,
            'alamat_sekarang'     => $request->alamat_sekarang,
            'usia'     => $request->usia,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'jenis_kasus_id'     => $request->jenis_kasus,
            'jenis_isolasi'     => $request->jenis_isolasi,
            'status' => $request->status,
            'lat'  => $lat,
            'lng'  => $lng,
        );

        $pasien = Pasien::create($input_data);

        if ($pasien->jenis_kasus_id == 1) {

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
                $randomString = ''; 
          
                for ($i = 0; $i < 9; $i++) { 
                    $index = rand(0, strlen($characters) - 1); 
                    $randomString .= $characters[$index]; 
                }

            $user_positif = array(
                'name'     => $pasien->nama,
                'nrp'      => 'po'.str_pad($pasien->id,4,'0',STR_PAD_LEFT),
                'role'     => 4,
                'password' => 'po'.str_pad($pasien->id,4,'0',STR_PAD_LEFT),
            );

            $users = User::create($user_positif);

                $data_user = array(
                    'user_id' => $users->id,
                );
                Pasien::where('id', $pasien->id)->update($data_user);
        }


        return redirect()->back()->with(['success' => 'Data Pasien dengan nama ' .$request->nama. ', Berhasil Ditambahkan.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUserPasien($pasienId)
    {
        if (Pasien::where('id', $pasienId)->where('user_id', '!=', NULL)->exists()) {
            alert()->warning('Maaf! Pasien ini telah mempunyai pengguna yang terdaftar pada sistem')->persistent('Close');
            return back();
        }
        else{
            $pasien = Pasien::where('id', $pasienId)->first();

            if ($pasien->jenis_kasus_id == 1) {

                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
                    $randomString = ''; 
              
                    for ($i = 0; $i < 9; $i++) { 
                        $index = rand(0, strlen($characters) - 1); 
                        $randomString .= $characters[$index]; 
                    }

                $user_positif = array(
                    'name'     => $pasien->nama,
                    'nrp'      => 'po'.str_pad($pasien->id,4,'0',STR_PAD_LEFT),
                    'role'     => 4,
                    'password' => 'po'.str_pad($pasien->id,4,'0',STR_PAD_LEFT),
                );

                $users = User::create($user_positif);

                $data_user = array(
                    'user_id' => $users->id,
                );
                Pasien::where('id', $pasienId)->update($data_user);
            }

            return redirect()->back()->with(['success' => 'Data Pengguna untuk pasien '.$pasien->nama. ' telah berhasil dibuat']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function show(Pasien $pasien)
    {
        $data = Pasien::where('id', $pasien->id)->first();
        $nama = User::select('name')->where('id', $pasien->petugas_id)->first()->name;
        $nrp = User::select('nrp')->where('id', $pasien->petugas_id)->first()->nrp;
 
        return response()->json(["data" => $data, "nama" => $nama, "nrp" => $nrp]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function edit(Pasien $pasien)
    {
        $data = Pasien::where('id', $pasien->id)->first();
 
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
            'alamat_ktp'       =>  'required',
            'alamat_sekarang'       =>  'required',
            'usia'       =>  'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Pasien tidak boleh dikosongi.',
                'alamat_ktp.required' => 'Maaf, Alamat KTP Pasien tidak boleh dikosongi.',
                'alamat_sekarang.required' => 'Maaf, Alamat Tinggal Pasien tidak boleh dikosongi.',
                'usia.required' => 'Maaf, Usia Pasien tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }
        
        $data_pasien = Pasien::where('id', $id)->first();
        
        if($request->has('jenis_kelamin')){
            $jenis_kelamin = $request->jenis_kelamin;}
        else{ $jenis_kelamin = $data_pasien->jenis_kelamin;}
        
        if($request->has('jenis_kasus_id')){
            $jenis_kasus_id = $request->jenis_kasus_id;}
        else{ $jenis_kasus_id = $data_pasien->jenis_kasus_id;}
        
        if($request->has('jenis_isolasi')){
            $jenis_isolasi = $request->jenis_isolasi;}
        else{ $jenis_isolasi = $data_pasien->jenis_isolasi;}
        
        if($request->has('status')){
            $status = $request->status;}
        else{ $status = $data_pasien->status;}
        
        if($request->has('kelurahan_id2')){
            $kelurahan_id = $request->kelurahan_id2;}
        else{ $kelurahan_id = $data_pasien->kelurahan_id;}

        $input_data = array(
            'petugas_id'    => Auth::user()->id,
            'nama'   =>  $request->nama,
            'kelurahan_id' => $kelurahan_id,
            'nik'    => $request->nik,
            'alamat_ktp'     => $request->alamat_ktp,
            'alamat_sekarang'     => $request->alamat_sekarang,
            'usia'     => $request->usia,
            'jenis_kelamin'     => $jenis_kelamin,
            'jenis_kasus_id'     => $jenis_kasus_id,
            'jenis_isolasi'     => $jenis_isolasi,
            'status' => $status,
            'user_id' => NULL,
        );

        Pasien::whereId($request->id)->update($input_data);
        
        $pasien = Pasien::where('id', $request->id)->first();
        
        if($status == "Meninggal" || $status == "Sembuh")
        {
            if($pasien->user_id != NULL)
            {
                if(User::where('id', $pasien->user_id)->exists())
                {
                    User::where('id', $pasien->user_id)->first()->delete();
                }
            }
            
            if(DB::table('penilaians')->where('user_id', $pasien->user_id)->exists())
            {
                $catatan = DB::table('penilaians')->where('user_id', $pasien->user_id)->get();
                
                foreach($catatan as $ct)
                {
                    $ct->delete();
                }
            }
            
            if(Panic::where('pasien_id', $pasien->id)->exists())
            {
                $panic = Panic::where('pasien_id', $pasien->id)->get();
                
                foreach($panic as $pc)
                {
                    $pc->delete();
                }
            }
        }
        elseif($status == "Dirawat") {
            if($pasien ->user_id == NULL || User::where('id', $pasien->user_id)->notExists())
            {
                if ($pasien->jenis_kasus_id == 1) {
    
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
                        $randomString = ''; 
                  
                        for ($i = 0; $i < 9; $i++) { 
                            $index = rand(0, strlen($characters) - 1); 
                            $randomString .= $characters[$index]; 
                        }
    
                    $user_positif = array(
                        'name'     => $pasien->nama,
                        'nrp'      => 'po'.str_pad($pasien->id,4,'0',STR_PAD_LEFT),
                        'role'     => 4,
                        'password' => 'po'.str_pad($pasien->id,4,'0',STR_PAD_LEFT),
                    );
    
                    $users = User::create($user_positif);
    
                    $data_user = array(
                        'user_id' => $users->id,
                    );
                    Pasien::where('id', $pasien->id)->update($data_user);
                }  
            }
        }
        
        return redirect()->back()->with(['success' => 'Data Pasien dengan nama ' .$request->nama. ', Berhasil Diupdate.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pasien $pasien)
    {   
        User::where('id', $pasien->user_id)->delete();
        Panic::where('pasien_id', $pasien->id)->delete();
        Penilaian::where('user_id', $pasien->user_id)->delete();
        $pasien->delete();

        return response()->json(['success' => 'Data deleted successfully.']);
    }
    
    public function panicIndex()
    {   
        if (Gate::allows('can_pasien')) {
            return abort(401);
        }
        if (Gate::allows('can_posko')) {
            return abort(401);
        }

        $panic = Panic::orderBy('created_at', 'desc')->limit(200)->get();
        
        return view('admin.pasien.panic', compact('panic'));
    }
    
    public function setIntervalPanic()
    {   
        if (Gate::allows('can_pasien')) {
            return abort(401);
        }
        if (Gate::allows('can_posko')) {
            return abort(401);
        }

        $panic = Panic::orderBy('created_at', 'desc')->limit(200)->get();
        
        return view('admin.pasien.panic_ajax', compact('panic'));
    }
    
    public function laporanPasienPositif(Request $request)
    {   
        if($request->session()->has('kel_id')){
			$request->session()->forget('kel_id');
		}
		
        $pasienPositif = Pasien::where('jenis_kasus_id', '1')->paginate(20);

        return view('admin.pasien.laporanPasienPositif', compact('pasienPositif'));
    }

    public function intervalLaporanPasienPositif(Request $request)
    {   
        if($request->session()->has('kel_id')){
            
            $kel_id = $request->session()->get('kel_id');
            $pasienPositif = Pasien::where('kelurahan_id', $kel_id)->where('jenis_kasus_id', '1')->get();
    
            return view('admin.pasien.laporanPasienPositif_ajax', compact('pasienPositif'));
        }
        else{
            $pasienPositif = Pasien::where('jenis_kasus_id', '1')->paginate(20);
    
            return view('admin.pasien.laporanPasienPositif_ajax', compact('pasienPositif'));
        }
    }
    
    
}
