<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Matkul;
use App\Module;

class ModuleController extends Controller
{
    public function index() {
        if (Auth::user()->isMhs()) {
            $matkuls = Matkul::orderBy('name', 'ASC')->paginate(9);
            return view('module', compact('matkuls'));
        }

        $matkuls = Matkul::orderBy('name', 'ASC')->paginate(6);
        return view('admin.module.index', compact('matkuls'));
    }

    public function show($slug)
    {
        $matkul = Matkul::where('slug', $slug)->first();
        $modules = Module::where('matkul_id', $matkul->id)->paginate(10);
        return view('admin.module.module', compact('matkul', 'modules'));
    }

    public function download($slug, $filename) {
        $file_path = public_path('file/module/'.$slug.'/'.$filename);
        if (file_exists($file_path)) {
            return response()->download($file_path);
        }
    }
}
