<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function kelas() {
    	return $this->belongsTo('App\Kelas');
    }

    public function angkatan() {
    	return $this->belongsTo('App\Angkatan');
    }
}
