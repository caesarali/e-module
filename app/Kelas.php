<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['name'];

    public function mahasiswa() {
    	return $this->hasMany('App\Mahasiswa');
    }
}
