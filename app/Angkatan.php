<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    protected $table = 'angkatan';

    protected $fillable = ['tahun'];

    public function mahasiswa() {
    	return $this->hasMany('App\Mahasiswa');
    }
}
