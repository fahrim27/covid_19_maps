<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisKasus extends Model
{
    protected $table = 'jenis_kasuses';
    protected $fillable = ['nama'];
    protected $primaryKey = 'id'; // or null

    public function pasien()
    {
    	return $this->hasMany('App\Pasien', 'id', 'jenis_kasus_id');
    }
}
