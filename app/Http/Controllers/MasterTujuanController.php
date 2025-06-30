<?php

namespace App\Http\Controllers;

use App\Models\TujuanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class MasterTujuanController extends Controller
{
    public function index()
    {   
        $data['tujuan'] = TujuanModel::get();

        // return $data
        return view('pages.master.tujuan.index',$data);
    }

    public function create()
    {
        
        return view('pages.master.tujuan.tambah');
       
    }

    public function store(Request $request)
    {
        // return $request->all();
      
        $validator = validator::make($request->all(), [

                
            'nama' => 'required',
            'deskripsi' => 'required',
            
        ]);

        if ($validator->fails()) {
            return redirect::back()->withErrors($validator)->withInput($request->all());
        }
        //   return $request->all();
        TujuanModel::create([
            'id' => $request->idtujuan,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
         
        ]);
       

        
        return redirect('/mastertujuan')->with('success', 'Data Berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        
        $data['edit'] = TujuanModel::where('id', $id)->first();
        return view('pages.master.tujuan.edit', $data);
    }

    public function edit()
    {
       
    }

    public function update(Request $request, $id)
    {
        // Validasi Input
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);
    
        // Update Data Tujuan
        $tujuan = TujuanModel::findOrFail($id);
        $tujuan->nama = $request->nama;
        $tujuan->deskripsi = $request->deskripsi;
        $tujuan->save();
    
        return redirect()->route('mastertujuan.index')->with('success', 'Data berhasil diperbarui!');
    }
    
    
    public function destroy(string $id)
        {

            TujuanModel::where('id', $id)->delete();
            return redirect('/mastertujuan')->with('success', 'Berhasil hapus data');
        }
}
