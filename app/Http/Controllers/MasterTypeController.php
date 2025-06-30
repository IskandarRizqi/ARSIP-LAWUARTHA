<?php

namespace App\Http\Controllers;

use App\Models\TypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class MasterTypeController extends Controller
{
    public function index()
    {   
        $data['type'] = TypeModel::get();
        return view('pages.master.type.index',$data);
    }

    public function create()
    {
        
        return view('pages.master.type.tambah');
       
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
        TypeModel::create([
            'id' => $request->idtype,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
         
        ]);
       

        
        return redirect('/mastertype')->with('success', 'Data Berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        
        $data['edit'] = TypeModel::where('id', $id)->first();
        return view('pages.master.type.edit', $data);
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
            'deskripsi' => 'required|string',
        ]);
    
        // Update Data Type
        $type = TypeModel::findOrFail($id);
        $type->nama = $request->nama;
        $type->deskripsi = $request->deskripsi;
        $type->save();
    
        return redirect()->route('mastertype.index')->with('success', 'Data Berhasil diperbarui!');
    }
    

    
    public function destroy(string $id)
        {

            TypeModel::where('id', $id)->delete();
            return redirect('/mastertype')->with('success', 'Berhasil hapus data!');
        }
}
