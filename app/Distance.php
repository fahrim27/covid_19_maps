<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    protected $table = 'distances';
    protected $fillable = ['nama', 'keterangan', 'polyline', 'kelurahan_id'];
    protected $primaryKey = 'id'; // or null

    public function kelurahan()
    {
    	return $this->belongsTo('App\Kelurahan', 'kelurahan_id', 'id');
    }
}
