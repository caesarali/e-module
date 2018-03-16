<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    protected $table = 'matkul';

    protected $fillable = ['name', 'slug'];

    public function module() {
    	return $this->hasMany('App\Module');
    }
}
