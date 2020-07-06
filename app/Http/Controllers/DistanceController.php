<?php

namespace App\Http\Controllers;

use App\Distance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Kelurahan;
use App\Kecamatan;
use Validator;

class DistanceController extends Controller
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
        
        $getAllDistance = Distance::get();
        $kecamatan = Kecamatan::get();

        return view('admin.distance.index', compact('getAllDistance', 'kecamatan'));
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
            'keterangan'      =>  'required',
            'poly'     =>  'required',
            'kelurahan_id2' => 'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Physical Distancing tidak boleh dikosongi.',
                'keterangan.required' => 'Maaf, Keterangan Physical Distancing tidak boleh dikosongi.',
                'poly.required' => 'Maaf, Daerah Physical Distancing tidak boleh dikosongi.',
                'kelurahan_id2.required' => 'Maaf, Nama Kelurahan tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        if (count($request->poly) > 1) {
            foreach ($request->poly as $key => $poly) {
                $input_data = array(
                    'nama'   =>  $request->nama,
                    'keterangan' => $request->keterangan,
                    'polyline'    => $request->poly,
                    'kelurahan_id'     => $request->kelurahan_id2,
                );

                $distance = Distance::create($input_data);
            }

            $kelurahan = Kelurahan::select('nama')->where('id', $request->kelurahan_id2)->first()->nama;

            return redirect()->back()->with(['success' => 'Sebanyak '.count($request->poly).' Data Physical Distancing, untuk Kelurahan ' .$kelurahan. ' Berhasil Ditambahkan.']);
            //$poly = $request->poly[count($request->poly) - 1];
        }
        else{
            $input_data = array(
                'nama'   =>  $request->nama,
                'keterangan' => $request->keterangan,
                'polyline'    => $request->poly[0],
                'kelurahan_id'     => $request->kelurahan_id2,
            );

            $distance = Distance::create($input_data);

            $kelurahan = Kelurahan::select('nama')->where('id', $request->kelurahan_id2)->first()->nama;

            return redirect()->back()->with(['success' => 'Data Physical Distancing ' .$request->nama. ', untuk Kelurahan ' .$kelurahan. ' Berhasil Ditambahkan.']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function show(Distance $distance)
    {
        $data = Distance::where('id', $distance->id)->first();

            $poly = Distance::select('polyline')->where('id', $distance->id)->first()->polyline;
            $ex = explode (",", $poly);
            $count = count($ex)-1;

            for ($x = 0; $x <= $count; $x+=2) {
               $distance2[] = array(
                    -$ex[$x],
                    +$ex[$x+1]
               );
            }
 
        return response()->json(["data" => $data, "distance" => $distance2]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function edit(Distance $distance)
    {   
        if (! Gate::allows('can_petugas')) {
            return abort(401);
        }

        $data = Distance::where('id', $distance->id)->first();
 
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
            'keterangan'      =>  'required',
            'kelurahan_id' => 'required',
        );

        $messages = array(
                'nama.required' => 'Maaf, Nama Physical Distancing tidak boleh dikosongi.',
                'keterangan.required' => 'Maaf, Keterangan Physical Distancing tidak boleh dikosongi.',
                'kelurahan_id.required' => 'Maaf, Nama Kelurahan tidak boleh dikosongi.',
            );

        $error = Validator::make($request->all(), $rules, $messages);

        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $input_data = array(
            'nama'   =>  $request->nama,
            'keterangan' => $request->keterangan,
            'kelurahan_id'     => $request->kelurahan_id,
        );

        Distance::whereId($request->id)->update($input_data);

        return redirect()->back()->with(['success' => 'Data Physical Distancing ' .$request->nama. ' Berhasil Diupdate.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Distance $distance)
    {   
        if (! Gate::allows('can_petugas')) {
            return abort(401);
        }
        
        $distance->delete();

        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
