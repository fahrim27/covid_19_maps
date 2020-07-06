<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    protected $table = 'rumah_sakits';
    protected $fillable = ['nama', 'no_hp', 'jumlah', 'lat', 'lng', 'kelurahan_id'];
    protected $primaryKey = 'id'; // or null

    public function kelurahan()
    {
    	return $this->belongsTo('App\Kelurahan', 'kelurahan_id', 'id');
    }
}
