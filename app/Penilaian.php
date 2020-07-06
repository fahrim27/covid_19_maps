<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaians';
    protected $fillable = ['user_id', 'rundown_id', 'keterangan', 'foto', 'status'];
    protected $primaryKey = 'id'; // or null

    public function users()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function rundown()
    {
    	return $this->belongsTo('App\Rundown', 'rundown_id', 'id');
    }
}
