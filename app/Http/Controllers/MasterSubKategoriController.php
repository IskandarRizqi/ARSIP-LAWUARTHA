<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use App\Models\SubKategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;

class MasterSubKategoriController extends Controller
{
    public function index()

      
    {    
       $data['kategori'] = DB::table('subkategori')
        ->join('kategori', 'kategori.id', '=', 'subkategori.kategori')
        ->select('subkategori.*', 'kategori.nama as kategori')
        ->get();

        // $data['subkategori'] = SubKategoriModel::get();
        // return $data;

        return view('pages.master.subkategori.index',$data);
    }

    public function create()
    {
        // return ['p'];
        $data['kategori'] = KategoriModel::get();
        return view('pages.master.subkategori.tambah',$data);
       
    }

    public function store(Request $request)
    {
        // return $request->all();
      
        $validator = validator::make($request->all(), [

                
            'nama' => 'required',
            'kategori' => 'required',
            
        ]);

        if ($validator->fails()) {
            return redirect::back()->withErrors($validator)->withInput($request->all());
        }
        //   return $request->all();
        SubKategoriModel::create([
            'id' => $request->idsubkategori,
            'nama' => $request->nama,
            'kategori' => $request->kategori,
         
        ]);
       

        
        return redirect('/mastersubkategori')->with('success', 'Data Berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        
        $data['edit'] = SubKategoriModel::where('id', $id)->first();
        $data['kategori'] = KategoriModel::get();
        return view('pages.master.subkategori.edit', $data);
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
        'kategori' => 'required|string',
    ]);

    // Update Data Kategori
    $subkategori = SubKategoriModel::findOrFail($id);
    $subkategori->nama = $request->nama;
    $subkategori->kategori = $request->kategori;
    $subkategori->save();

    return redirect()->route('mastersubkategori.index')->with('success', 'Data berhasil diperbarui!');
}




    
    public function destroy(string $id)
        {

            SubKategoriModel::where('id', $id)->delete();
            return redirect('/mastersubkategori')->with('success', 'Berhasil hapus data');
        }
}
