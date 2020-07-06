<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Panic extends Model
{
    protected $table = 'panic';
    protected $fillable = ['pasien_id', 'kelurahan_id', 'status'];
  
    public function kelurahan()
    {
    	return $this->belongsTo('App\Kelurahan', 'kelurahan_id', 'id');
    }

    public function pasien()
    {
        return $this->belongsTo('App\Pasien', 'pasien_id', 'id');
    }
}
