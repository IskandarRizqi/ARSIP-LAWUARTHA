<?php

namespace App\Http\Controllers;

use App\Models\ArsipModel;
use App\Models\KategoriModel;
use App\Models\SubKategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;

class KategoriController extends Controller
{
    public function index()
    {   
        // $data['kategori'] = DB::table('kategori')
        // ->join('subkategori', 'kategori.sub', '=', 'subkategori.id')
        // ->select('kategori.*', 'subkategori.nama as sub_nama')
        // ->get();
        
        $data['kategori'] = KategoriModel::get();
        // return $data;
       
        return view('pages.kategori.index',$data);
    }

    public function create()
    {
        // return ['p'];
        // $data['subkategori'] = SubKategoriModel::get();
        return view('pages.kategori.tambah');
       
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
        KategoriModel::create([
            'id' => $request->idkategori,
            'nama' => $request->nama,
           
         
        ]);
       

        
        return redirect('/menukategori')->with('success', 'Data Berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        
        $data['edit'] = KategoriModel::where('id', $id)->first();
    
        return view('pages.kategori.edit', $data);
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
    $kategori = KategoriModel::findOrFail($id);
    $kategori->nama = $request->nama;
   
    $kategori->save();

    return redirect()->route('menukategori.index')->with('success', 'Data berhasil diperbarui!');
}


    // public function update(Request $request, string $id)
    // {
    //     $validator = validator::make($request->all(), [
          
           
    //         'nama' => 'required',
    //         'deskripsi' => 'required',
         
    //     ]);
    //     if ($validator->fails()) {
    //         return redirect::back()->withErrors($validator)->withInput($request->all());
    //     }
    //     $i = [
          
    //         'nama' => $request->nama,
    //         'deskripsi' => $request->deskripsi,
            
    //     ];
      
    //     KategoriModel::where('id', $id)->update($i);

        
    //     return redirect('/menukategori');
    // }

    
    public function destroy(string $id)
        {

            KategoriModel::where('id', $id)->delete();
            return redirect('/menukategori')->with('success', 'Berhasil hapus data');
        }
    

// GENERATE PENGAJUAN DIGITAL

        public function getSubKategori($id)
        {
            $subkategori = DB::table('subkategori')
                ->where('kategori', $id)
                ->select('id', 'nama')
                ->get();
        
            return response()->json($subkategori);
        }
        
        // Mengambil arsip berdasarkan subkategori
        public function getArsipBySubKategori($id)
        {
            $arsip = DB::table('arsip')
                ->where('subkategori', $id) // Filter berdasarkan subkategori
                ->where('jenis_file', 'digital') // Pastikan hanya arsip digital yang diambil
                ->select('id', 'nama')
                ->get();
        
            return response()->json($arsip);
        }
        
        public function getArsipByKategori($id)
        {
            $arsip = DB::table('arsip')
                ->join('subkategori', 'arsip.subkategori', '=', 'subkategori.id')
                ->where('subkategori.kategori', $id) // Filter berdasarkan kategori
                ->where('arsip.jenis_file', 'digital') // Pastikan hanya arsip digital yang diambil
                ->select('arsip.id', 'arsip.nama')
                ->get();
        
            return response()->json($arsip);
        }
        


// GENERATE PENGAJUAN FISIK

public function getArsipFisik()
{
    $arsipFisik = DB::table('arsip')
        ->where('jenis_file', 'fisik') // Hanya arsip fisik
        ->select('nama')
        ->get();

    return response()->json($arsipFisik);
}

public function getArsipDetails($nama)
{
    $arsip = DB::table('arsip')
        ->where('nama', $nama)
        ->where('jenis_file', 'fisik') // Pastikan hanya arsip fisik
        ->select('lemari', 'rak', 'no')
        ->first();

    if (!$arsip) {
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    return response()->json($arsip);
}

       



}
