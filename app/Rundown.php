<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rundown extends Model
{
    protected $table = 'rundown';
    protected $fillable = ['jam', 'keterangan'];
    protected $primaryKey = 'id'; // or null
}
