<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use App\Mahasiswa;
use App\Kelas;
use App\Angkatan;
use App\User;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::orderBy('name', 'ASC')->get();
        $angkatan = Angkatan::orderBy('tahun', 'DESC')->get();
        $mahasiswa = Mahasiswa::orderBy('angkatan_id', 'DESC')->get();
        return view('admin.mahasiswa.index', compact('kelas', 'angkatan', 'mahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|unique:mahasiswa|max:9',
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'angkatan' => 'required|integer',
            'kelas' => 'required|string|max:5'
        ]);

        $username = explode('@', $request->email);

        $user = User::create([
            'username' => $request->nim,
            'email' => $request->email,
            'password' => bcrypt($username[0]),
        ]);
        $user->attachRole('mahasiswa');
        $this->createProfile($user, $request);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kelas = Kelas::orderBy('name', 'ASC')->get();
        $angkatan = Angkatan::orderBy('tahun', 'DESC')->get();
        $mhs = Mahasiswa::find($id);
        return view('admin.mahasiswa.edit', compact('kelas', 'angkatan', 'mhs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->nim !== $request->nim) {
            $request->validate([
                'nim' => 'required|string|unique:mahasiswa|max:9'
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:191',
            'angkatan' => 'required|integer',
            'kelas' => 'required|string|max:5'
        ]);

        $kelas = Kelas::firstOrCreate(['name' => $request->kelas]);
        $angkatan = Angkatan::firstOrCreate(['tahun' => $request->angkatan]);

        $mahasiswa->update([
            'name' => $request->name,
            'nim' => $request->nim,
            'angkatan_id' => $angkatan->id,
            'kelas_id' => $kelas->id
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Perubahan terhadap data mahasiswa telah disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->detachRole('mahasiswa');
        $user->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Data telah dihapus & akun tidak dapat digunakan untuk login lagi.');
    }

    private function createProfile($user, $request)
    {
        $kelas = Kelas::firstOrCreate(['name' => $request->kelas]);
        $angkatan = Angkatan::firstOrCreate(['tahun' => $request->angkatan]);

        return Mahasiswa::create([
            'nim' => $request->nim,
            'name' => $request->name,
            'user_id' => $user->id,
            'angkatan_id' => $angkatan->id,
            'kelas_id' => $kelas->id,
        ]);
    }

    public function mahasiswa(Request $request) {
        if ($request->angk === '*') {
            return redirect()->route('mahasiswa.index');
        }
        $kelas = Kelas::orderBy('name', 'ASC')->get();
        $angkatan = Angkatan::orderBy('tahun', 'DESC')->get();
        $angkatanSelect = $request->angk;
        $mahasiswa = Mahasiswa::where('angkatan_id', $request->angk)->get();
        return view('admin.mahasiswa.index', compact('kelas', 'angkatan', 'mahasiswa', 'angkatanSelect'));
    }
}
