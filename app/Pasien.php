<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasiens';
    protected $fillable = ['nik', 'nama', 'alamat_ktp', 'alamat_sekarang', 'usia', 'jenis_kelamin', 'jenis_kasus_id', 'jenis_isolasi', 'lat', 'lng', 'kelurahan_id', 'petugas_id', 'user_id', 'status'];
    protected $primaryKey = 'id'; // or null

    public function kelurahan()
    {
    	return $this->belongsTo('App\Kelurahan', 'kelurahan_id', 'id');
    }

    public function petugas()
    {
    	return $this->belongsTo('App\User', 'petugas_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function jenis_kasus()
    {
    	return $this->belongsTo('App\JenisKasus', 'jenis_kasus_id', 'id');
    }
}
