<?php

namespace App\Http\Controllers;

use App\Models\ArsipModel;
use App\Models\KategoriModel;
use App\Models\LemariModel;
use App\Models\SubKategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Auth;

class ArsipController extends Controller
{
    public function index()
    {   
        $data['arsip'] = DB::table('arsip')
        ->leftJoin('subkategori', 'subkategori.id', '=', 'arsip.subkategori') // Hubungkan ke subkategori
        ->leftJoin('kategori', 'kategori.id', '=', 'subkategori.kategori') // Hubungkan ke kategori
        ->select(
            'arsip.*',
            'kategori.nama as kategori_nama',  // Nama kategori
            'subkategori.nama as subkategori_nama' // Nama subkategori
        )
        // ->where('arsip.jenis_file', 'digital')
        ->orderBy('arsip.created_at', 'desc')
        ->get();

        // return $data;
      

        return view('pages.arsip.index',$data);
    }


    public function create()
    {

        $data['subkategori'] = SubKategoriModel::
        join('kategori', 'kategori.id', '=' , 'subkategori.kategori')
        -> select('kategori.nama as namakategori', 'subkategori.nama as subnama','subkategori.id as id')
        -> get();

        // return $data;
        $data['lemari'] = LemariModel::get();

        return view('pages.arsip.tambah', $data);
       
    }

    public function getSubkategori($kategori_id)
    {
        $subkategori = SubKategoriModel::where('kategori_id', $kategori_id)->get();
        return response()->json($subkategori);
    }


    public function store(Request $request)
{
    // Cek apakah digital atau fisik
    if ($request->jenis_file === 'digital') {
        // Validasi untuk file PDF dengan maksimal 150MB
        $request->validate([
           'file' => 'required|file|mimes:pdf|max:153600', // 150 MB = 153600 KB
            'kode' => 'required',
            'nama' => 'required',
            'subkategori' => 'required|exists:subkategori,id',
            'deskripsi' => 'required',
        ]);

        // Simpan file ke storage jika ada
       if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $fileSizeInBytes = $file->getSize(); // otomatis ambil ukuran file dalam byte
        } else {
            return back()->withErrors(['file' => 'File wajib diunggah']);
        }

        // Simpan ke database
        $arsip = new ArsipModel();
        $arsip->file = $filePath; 
        $arsip->kode = $request->kode;
        $arsip->size = $fileSizeInBytes;
        $arsip->nama = $request->nama;
        $arsip->subkategori = $request->subkategori;
        $arsip->deskripsi = $request->deskripsi;
        $arsip->jenis_file = 'digital';
        $arsip->save();
    } 
    elseif ($request->jenis_file === 'fisik') {
        // Validasi untuk arsip fisik
        $request->validate([
            'namaxxx' => 'required',
            'lemari' => 'required',
            'rak' => 'required',
            'no' => 'required',
            'subkategorixxx' => 'required|exists:subkategori,id',
            'deskripsixxx' => 'required',
        ]);

        // Simpan ke database
        $arsip = new ArsipModel();
        $arsip->nama = $request->namaxxx;
        $arsip->lemari = $request->lemari;
        $arsip->rak = $request->rak;
        $arsip->no = $request->no;
        $arsip->subkategori = $request->subkategorixxx;
        $arsip->deskripsi = $request->deskripsixxx;
        $arsip->jenis_file = 'fisik';
        $arsip->save();
    }

    return redirect()->route('menuarsip.index')->with('success', 'Arsip berhasil disimpan.');
}

    
public function show(string $id)
{
    $data['edit'] = ArsipModel::select(
        'arsip.*',
        'kategori.id as kategori_id',
        'kategori.nama as kategori_nama',
        'subkategori.id as subkategori_id',
        'subkategori.nama as subkategori_nama'
    )
    ->leftJoin('subkategori', 'subkategori.id', '=', 'arsip.subkategori')
    ->leftJoin('kategori', 'kategori.id', '=', 'subkategori.kategori')
    ->where('arsip.id', $id)
    ->first(); 

    $data['subkategori'] = SubkategoriModel::select('subkategori.*', 'kategori.nama as kategori_nama')
        ->leftJoin('kategori', 'kategori.id', '=', 'subkategori.kategori')
        ->get();

    $data['kategori'] = KategoriModel::all(); // Mengambil semua kategori

    $data['lemari'] = LemariModel::get();

    return view('pages.arsip.edit', $data);
}



    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // Ambil data arsip berdasarkan ID
        $arsip = ArsipModel::findOrFail($id);
    
        if ($arsip->jenis_file === 'digital') {
            // Validasi untuk file digital
            $request->validate([
                'file' => 'nullable|file|mimes:pdf|max:153600', // PDF max 150MB
                'kode' => 'required|string|max:255',
                'nama' => 'required|string|max:255',
                'subkategori' => 'required|exists:subkategori,id',
                'deskripsi' => 'required|string',
            ]);
    
           // Jika ada file baru
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($arsip->file && Storage::exists('public/' . $arsip->file)) {
                Storage::delete('public/' . $arsip->file);
            }

            // Simpan file baru
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');

            // Update file path & size
            $arsip->file = $filePath;
            $arsip->size = $file->getSize(); // byte
        }
    
            // Update data arsip digital 
            $arsip->kode = $request->kode;
            $arsip->nama = $request->nama;
            $arsip->subkategori = $request->subkategori;
            $arsip->deskripsi = $request->deskripsi;
        } 
        elseif ($arsip->jenis_file === 'fisik') {
            // Validasi untuk arsip fisik
            $request->validate([
                'namaxxx' => 'required',
                'lemari' => 'required',
                'rak' => 'required',
                'no' => 'required',
                'subkategorixxx' => 'required|exists:subkategori,id',
                'deskripsixxx' => 'required',
            ]);
    
            // Update data arsip fisik
            $arsip->nama = $request->namaxxx;
            $arsip->lemari = $request->lemari;
            $arsip->rak = $request->rak;
            $arsip->no = $request->no;
            $arsip->subkategori = $request->subkategorixxx;
            $arsip->deskripsi = $request->deskripsixxx;
        }
    
        // Simpan perubahan
        $arsip->save();
    
        return redirect()->route('menuarsip.index')->with('success', 'Arsip berhasil diperbarui!');
    }


    public function destroy(string $id)
        {

            ArsipModel::where('id', $id)->delete();
            return redirect('/menuarsip')->with('success', 'Berhasil hapus data!');
        }
    
}
