<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahans';
    protected $fillable = ['nama', 'kecamatan_id'];
    protected $primaryKey = 'id'; // or null

    public function kecamatan()
    {
    	return $this->belongsTo('App\Kecamatan', 'kecamatan_id', 'id');
    }
    
    public function pasien()
    {
    	return $this->hasMany('App\Pasien', 'kelurahan_id', 'id');
    }
}
