<?php

namespace App\Http\Controllers;

use App\Models\PetugasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class PetugasController extends Controller
{
    public function index()
    {   
        $data['petugas'] = PetugasModel::get();
        return view('pages.petugas.index',$data);
    }


    public function create()
    {

        return view('pages.petugas.tambah');
       
    }

    public function store(Request $request)
{
    $request->validate([
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'nama' => 'required',
        'username' => 'required',
        'password' => 'required',
        'jabatan' => 'required',
    ]);

    // Simpan gambar
    if ($request->hasFile('gambar')) {
        $gambarPath = $request->file('gambar')->store('uploads', 'public');
    } else {
        return back()->withErrors(['gambar' => 'Gambar wajib diunggah']);
    }

    // Simpan ke database
    PetugasModel::create([
        'gambar' => $gambarPath,
        'nama' => $request->nama,
        'username' => $request->username,
        'password' => bcrypt($request->password),
        'jabatan' => $request->jabatan,
    ]);

    return redirect()->route('menupetugas.index')->with('success', 'Petugas berhasil ditambahkan!');
}


    public function show(string $id)
    {
        
        $data['edit'] = PetugasModel::where('id', $id)->first();
        return view('pages.petugas.edit', $data);
    }

    public function edit(string $id)
    {
        //
    }

    // public function update(Request $request, string $id)
    // {

    //     if ($request->hasFile('gambar')) { 
    //         $file = $request->file('gambar')->store('petugas/' . time());


    //     $validator = validator::make($request->all(), [
          
           
    //         'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //         'nama' => 'required',
    //         'username' => 'required',
    //         'password' => 'required',
    //         'jabatan' => 'required',
         
    //     ]);
    //     if ($validator->fails()) {
    //         return redirect::back()->withErrors($validator)->withInput($request->all());
    //     }
    //     $i = [
          
    //         'id' => $request->idpetugas,
    //         'gambar' => $request-> $file,
    //         'nama' => $request->nama,
    //         'username' => $request->username,
    //         'password' => $request->password,
    //         'jabatan' => $request->jabatan,
            
    //     ];
      
    //     PetugasModel::where('id', $id)->update($i);

        
    //     return redirect('/menupetugas');
    //     }
    // }

    
    public function destroy(string $id)
        {

            PetugasModel::where('id', $id)->delete();
            return redirect('/menupetugas')->with('success', 'Berhasil hapus data');
        }
    

  
}
