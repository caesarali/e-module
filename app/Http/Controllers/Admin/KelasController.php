<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kelas;
use App\Angkatan;

class KelasController extends Controller
{
    public function index() {
    	$kelas = Kelas::orderBy('name', 'ASC')->get();
    	$angkatan = Angkatan::orderBy('tahun', 'DESC')->get();
    	return view('admin.kelas.index', compact('kelas', 'angkatan'));
    }

    public function storeKelas(Request $request) {
    	$data = $request->validate([
    		'name' => 'required|string|unique:kelas|max:5'
    	]);

    	Kelas::create([
    		'name' => strtoupper($request->name)
    	]);

    	return redirect()->route('kelas.index')->with('success-kelas','Kelas '.$request->name.' berhasil ditambahkan.');
    }

    public function destroyKelas($id) {
    	$kelas = Kelas::find($id);
    	if ($kelas->mahasiswa->count() > 0) {
    		return redirect()->route('kelas.index')->with('error-kelas', 'Data kelas tidak dapat dihapus, data ini masih diperlukan dan berelasi dengan data mahasiswa.');
    	}
    	$kelas->delete();
    	return redirect()->route('kelas.index')->with('success-kelas','Kelas '.$kelas->name.' telah dihapus.');	
    }

    public function storeAngkatan(Request $request) {
    	$data = $request->validate([
    		'tahun' => 'required|integer|unique:angkatan'
    	]);

    	Angkatan::create($data);

    	return redirect()->route('kelas.index')->with('success-angkatan','Tahun angkatan ditambahkan.');
    }

    public function destroyAngkatan($id) {
    	$angkatan = Angkatan::find($id);
    	if ($angkatan->mahasiswa->count() > 0) {
    		return redirect()->route('kelas.index')->with('error-angkatan', 'Data tahun angkatan tidak dapat dihapus, data ini diperlukan dan berelasi dengan data mahasiswa.');
    	}
    	$angkatan->delete();
    	return redirect()->route('kelas.index')->with('success-angkatan','Tahun angkatan '.$angkatan->tahun.' dihapus.');	
    }
}
