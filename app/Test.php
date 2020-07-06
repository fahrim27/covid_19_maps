<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'tests';
    protected $fillable = ['pasien_id', 'jenis_tes', 'tgl_tes', 'tgl_hasil_tes', 'keterangan', 'foto'];
    protected $primaryKey = 'id'; // or null

    public function pasien()
    {
    	return $this->belongsTo('App\Pasien', 'pasien_id', 'id');
    }

}
