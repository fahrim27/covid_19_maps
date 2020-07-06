<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
use Auth;

class DinasController extends Controller
{
    private $pasien;

    public function __construct()
    {
    	return $this->middleware('auth');
    }

    public function dashboard()
    {
    	return view('dinas.dashboard');
    }

    public function index()
    {	
    	$user_id = Auth::user()->role;

    	if ($user_id == 5) {

    		$getAllPasiens = Pasien::where('jenis_isolasi', 2)->paginate(25);
    	}
    	elseif($user_id == 6) {

    		$getAllPasiens = Pasien::where('jenis_isolasi', 3)->paginate(25);
    	}

        return view('dinas.index', compact('getAllPasiens'));
    }

    public function laporanPasienPositif()
    {	
    	$user_id = Auth::user()->role;

    	if ($user_id == 5) {

    		$pasienPositif = Pasien::where('jenis_isolasi', 2)->where('jenis_kasus_id', '1')->paginate(20);
    	}
    	elseif($user_id == 6) {

    		$pasienPositif = Pasien::where('jenis_isolasi', 3)->where('jenis_kasus_id', '1')->paginate(20);
    	}

        return view('dinas.laporanPasienPositif', compact('pasienPositif'));
    }

    public function intervalLaporanPasienPositif()
    {	
    	$user_id = Auth::user()->role;

    	if ($user_id == 5) {

    		$pasienPositif = Pasien::where('jenis_isolasi', 2)->where('jenis_kasus_id', '1')->paginate(20);
    	}
    	elseif($user_id == 6) {

    		$pasienPositif = Pasien::where('jenis_isolasi', 3)->where('jenis_kasus_id', '1')->paginate(20);
    	}

        return view('dinas.laporanPasienPositif_ajax', compact('pasienPositif'));
    }    
}
