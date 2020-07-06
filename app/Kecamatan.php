<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatans';
    protected $fillable = ['nama'];
    protected $primaryKey = 'id'; // or null

    public function kelurahan()
    {
    	return $this->hasMany('App\Kelurahan', 'kecamatan_id', 'id');
    }

}
