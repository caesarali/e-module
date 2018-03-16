<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function dosen() {
        return $this->hasOne('App\Dosen');
    }

    public function mahasiswa() {
        return $this->hasOne('App\Mahasiswa');
    }

    public function modules() {
        return $this->hasMany('App\Module');
    }

    public function role() {
        return $this->belongsToMany('App\Role');
    }

    public function attachRole($role) {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        return $this->role()->attach($role);
    }

    public function detachRole($role) {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        return $this->role()->detach($role);
    }

    public function hasRole($name) {
        foreach ($this->role as $role) {
            if ($role->name === $name) {
                return true;
            }
        } return false;
    }

    public function isAdmin() {
        if ($this->hasRole('admin')) {
            return true;
        }
        return false;
    }

    public function isDosen() {
        if ($this->hasRole('dosen')) {
            return true;
        }
        return false;
    }

    public function isMhs() {
        if ($this->hasRole('mahasiswa')) {
            return true;
        }
        return false;
    }
}
