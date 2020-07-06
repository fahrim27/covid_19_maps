<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posko;
use App\User;
use DB;

class UserPoskoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($poskoId)
    {   

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($poskoId)
    {
        if (DB::table('posko_user')->where('posko_id', $poskoId)->exists()) {
            alert()->warning('Maaf! Posko ini telah mempunyai pengguna yang terdaftar pada sistem')->persistent('Close');
            return back();
        }
        else{
            $namaPosko = Posko::select('nama')->where('id', $poskoId)->first()->nama;

            $users = new User;
            $users->name = 'Posko-'.$poskoId;
            $users->nrp = 'posko-'.$poskoId;
            $users->password = bcrypt('posko'.$poskoId);
            $users->role = 3;
            $users->save();

            $data_user = array(
                'posko_id' => $poskoId,
                'user_id' => $users->id,
            );
            DB::table('posko_user')->insert($data_user);

            return redirect()->back()->with(['success' => 'Data Pengguna untuk posko '.$namaPosko. ' telah berhasil dibuat']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($poskoId)
    {
        $user_posko = User::whereHas('posko', function ($query) use ($poskoId) {
            $query->whereIn('posko_id', $poskoId);
        })->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {    
        $user_posko = User::find($id);
        $user_posko->posko()->detach();
        $user_posko->delete();

            user_posko()->success('Pengguna pada posko' .$user_posko->nama.' Telah Berhasil di Hapus', 'Sukses!')->autoclose('5000');
            return back();
    }
}
