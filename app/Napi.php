<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Napi extends Model
{
    protected $table = 'napis';
    protected $fillable = ['nama', 'lat', 'lng', 'kelurahan_id', 'petugas_id'];
    protected $primaryKey = 'id'; // or null

    public function kelurahan()
    {
    	return $this->belongsTo('App\Kelurahan', 'kelurahan_id', 'id');
    }

    public function petugas()
    {
    	return $this->belongsTo('App\User', 'petugas_id', 'id');
    }

}
