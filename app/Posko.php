<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posko extends Model
{
    protected $table = 'poskos';
    protected $fillable = ['nama', 'lat', 'lng', 'kelurahan_id'];
    protected $primaryKey = 'id'; // or null

    public function kelurahan()
    {
    	return $this->belongsTo('App\Kelurahan', 'kelurahan_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
