<?php

namespace App\Http\Controllers;

use App\Models\LemariModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class MasterLemari extends Controller
{
    public function index()
    {   
        $data['lemari'] = LemariModel::get();
        return view('pages.master.lemari.index',$data);
    }

    public function create()
    {
        // return ['p'];
        return view('pages.master.lemari.tambah');
       
    }

    public function store(Request $request)
    {
        // return $request->all();
      
        $validator = validator::make($request->all(), [

                
            'nama' => 'required',
      
            
        ]);

        if ($validator->fails()) {
            return redirect::back()->withErrors($validator)->withInput($request->all());
        }
        //   return $request->all();
        LemariModel::create([
            'id' => $request->idlemari,
            'nama' => $request->nama,
          
         
        ]);
       

        
        return redirect('/masterlemari')->with('success', 'Data Berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        
        $data['edit'] = LemariModel::where('id', $id)->first();
        return view('pages.master.lemari.edit', $data);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, $id)
{
    // Validasi Input
    $request->validate([
        'nama' => 'required|string|max:255',
     
    ]);

    // Update Data Kategori
    $lemari = LemariModel::findOrFail($id);
    $lemari->nama = $request->nama;
   
    $lemari->save();

    return redirect()->route('masterlemari.index')->with('success', 'Data berhasil diperbarui!');
}




    
    public function destroy(string $id)
        {

            LemariModel::where('id', $id)->delete();
            return redirect('/masterlemari')->with('success', 'Berhasil hapus data');
        }
}
