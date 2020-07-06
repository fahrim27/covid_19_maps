<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class UserController extends Controller
{   
    public function __construct()
    {   
    }

    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if (Gate::allows('can_petugas')) {
            return abort(401);
        }

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function petugasHistory()
    {   
        if (Gate::allows('can_petugas')) {
            return abort(401);
        }

        $users = User::where('role', 2)->get();

        return view('admin.users.petugas_history', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $rules = array(
            'name'          =>  'required',
            'nrp'           =>  'required|unique:users,nrp',
            'password'      =>  'required',
            'role'          =>  'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama User tidak boleh dikosongi.',
                'nrp.required' => 'Maaf, NRP User tidak boleh dikosongi.',
                'password.required' => 'Maaf, Password User tidak boleh dikosongi.',
                'role.required' => 'Maaf, Role User tidak boleh dikosongi.',
                'nrp.unique:users,nrp' => 'Maaf, Nrp ini sudah terdaftar sebagai pengguna aktif.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'name'      =>  $request->name,
            'nrp'       =>  $request->nrp,
            'role'      =>  $request->role,
            'password'  =>  bcrypt($request->password),
        );

        $jenis_kasus = User::create($input_data);

        return redirect()->back()->with(['success' => 'Data User degan nama ' .strtoupper($request->nama). ' Berhasil Ditambahkan.']);
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data = User::where('id', $user->id)->first();
 
        return response()->json(["data" => $data]);
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = array(
            'name'          =>  'required',
            'nrp'           =>  'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama User tidak boleh dikosongi.',
                'nrp.required' => 'Maaf, NRP User tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'name'      =>  $request->name,
            'nrp'       =>  $request->nrp,
        );

        $user::whereId($request->id)->update($input_data);

        return redirect()->back()->with(['success' => 'Data User degan nama ' .strtoupper($request->nama). ' Berhasil Diupdate.']);
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $user;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['success' => 'Data User Berhasil Dihapus.']);
    }

    public function import_excel(Request $request) 
    {   
        ini_set('precision', '16');
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '512M');

        $rules = array(
            'file' => 'required|mimes:csv,xls,xlsx',
            'role' => 'required',
        );

        $messages = array(
                'file.required' => 'Maaf, File import tidak boleh kosong.',
                'file.mimes:csv,xls,xlsx' => 'Maaf, File yang Anda Masukkan harus berupa csv, xls, atau xlsx.',
                'role.required' => 'Maaf, pilihan Role User tidak boleh kosong.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        $path = $request->file('file')->getRealPath();
        $data = Excel::load($path)->get();       

            if($data->count() > 0)
            {
                foreach($data->toArray() as $row)
                {
                    if( !User::where('nrp', $row['nrp'])->exists() ) {
                        $insert_data[] = array(
                            'name'=> $row['name'], 
                            'nrp'=> $row['nrp'], 
                            'password'=>  bcrypt($row['password']), 
                            // 'no_hp'=> $row['no_hp'], 
                            'role'=> $request->role,
                        );
                    }
                    else {
                        $allready_exists[] = array(
                            'name'=> $row['name'], 
                            'nrp'=> $row['nrp'], 
                            'password'=>  bcrypt($row['password']), 
                            // 'no_hp'=> $row['no_hp'], 
                            'role'=> $request->role,
                        );
                    }
                }

                if(!empty($insert_data))
                {
                    $chunk_data = array_chunk($insert_data, 20);
                    if (isset($chunk_data) && !empty($chunk_data)) {
                        foreach ($chunk_data as $chunk_data_val) {
                            DB::table('dpt_import')->insert($chunk_data_val);
                        }
                    }

                    $getCountImport = count($insert_data);
                }

                $getCountExists = count($allready_exists);

                if ($request->role == 1) {
                    $role = "Admin";
                }
                else{
                    $role = "Petugas";
                }
            }

        if ($getCountExists  == 0) {
            return response()->json(['success' => 'Import data User sebanyak ' .$getCountImport. ' orang, untuk role ' .$role. '. Telah Berhasil! ']);
        }
        else {
            return response()->json(['success' => 'Import data User sebanyak ' .$getCountImport. ' orang, untuk role ' .$role. '. Telah Berhasil! & ' .$getCountExists. ' data user gagal di import karena ada kesamaan NRP dengan data yang telah ada']);
        }  
    }

}
