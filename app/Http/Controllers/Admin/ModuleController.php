<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use File;
use App\Matkul;
use App\Module;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matkuls = Matkul::orderBy('name', 'ASC')->paginate(6);
        return view('admin.module.index', compact('matkuls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'module' => 'required|mimes:pdf,doc,docx|max:2048',
            'deskripsi' => 'required|string'
        ]);

        $matkul = Matkul::find($request->matkul_id);

        if ($request->hasFile('module') && $request->file('module')->isValid()) {
            $extension = $request->module->extension();
            $slug = $matkul->slug;
            $date = date('Ymd-His');
            $filename = $slug . '-' . $date . '.' . $extension;
            $path = public_path('file/module/'.$slug);
            $store = $request->module->move($path, $filename);
            Module::create([
                'matkul_id' => $matkul->id,
                'user_id' => Auth::id(),
                'nama_file' => $filename,
                'deskripsi' => $request->deskripsi,
            ]);

            if (Auth::user()->isDosen()) {
                return redirect()->route('show.module', $matkul->slug)->with('success','Module berhasil di-upload.');
            }
            return redirect()->route('module.show', $matkul->slug)->with('success','Module berhasil di-upload.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $matkul = Matkul::where('slug', $slug)->first();
        $modules = Module::where('matkul_id', $matkul->id)->paginate(10);
        return view('admin.module.module', compact('matkul', 'modules'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $module = Module::find($id);
        $file_path = public_path('file/module/'.$module->matkul->slug.'/'.$module->nama_file);
        File::delete($file_path);
        $module->delete();
        if (Auth::user()->isDosen()) {
            return redirect()->route('show.module', $module->matkul->slug)->with('success','Module berhasil di-hapus.');
        }
        return redirect()->route('module.show', $module->matkul->slug)->with('success','Module berhasil di-hapus.');
    }

    // public function download($slug, $filename) {
    //     $file_path = public_path('file/module/'.$slug.'/'.$filename);
    //     if (file_exists($file_path)) {
    //         return response()->download($file_path);
    //     }
    // }
}
