<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mahasiswa;
use App\Dosen;
use App\Module;

class HomeController extends Controller
{
    public function index()
    {
    	$dosens = Dosen::all();
    	$mahasiswa = Mahasiswa::all();
    	$modules = Module::all();
    	return view('admin.home', compact('dosens', 'mahasiswa', 'modules'));
    }
}
