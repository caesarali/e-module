<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'module';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function matkul() {
    	return $this->belongsTo('App\Matkul');
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }
}
