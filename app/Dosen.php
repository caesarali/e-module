<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user() {
    	return $this->belongsTo('App\User');
    }
}
