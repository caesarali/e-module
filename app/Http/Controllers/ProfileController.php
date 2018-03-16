<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Angkatan;
use App\Kelas;
use Auth;
use App\User;
use App\Dosen;
use App\Mahasiswa;

class ProfileController extends Controller
{
    public function index()
    {
    	$kelas = Kelas::orderBy('name', 'ASC')->get();
        $angkatan = Angkatan::orderBy('tahun', 'DESC')->get();
        $user = User::find(Auth::id());
    	return view('profile', compact('kelas', 'angkatan', 'user'));
    }

    public function update(Request $request)
    {
        if (Auth::user()->email !== $request->email) {
            $request->validate([
                'email' => 'required|string|email|max:191|unique:users',
            ]);
        }

    	if (Auth::user()->isMhs()) {
    		$request->validate([
    			'name' => 'required|string',
    			'angkatan' => 'required',
    			'kelas' => 'required',
    			'phone' => 'required|string|max:12'
    		]);
    		$this->updateMahasiswa($request);
    	} else {
    		$request->validate([
    			'name' => 'required|string',
    			'phone' => 'required|string|max:12'
    		]);
    		$this->updateDosen($request);
    	}

        $user = User::find(Auth::id());
        $user->email = $request->email;
        $user->save();

    	return redirect()->route('profile.index')->with('success', 'Perubahan disimpan.');
    }

    private function updateMahasiswa($data)
    {
    	Mahasiswa::where('user_id', Auth::id())->update([
    		'name' => $data->name,
    		'angkatan_id' => $data->angkatan,
    		'kelas_id' => $data->kelas,
    		'phone' => $data->phone
    	]);
    }

    private function updateDosen($data)
    {
    	Dosen::where('user_id', Auth::id())->update([
    		'name' => $data->name,
    		'phone' => $data->phone
    	]);
    }
}
