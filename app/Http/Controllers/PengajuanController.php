<?php

namespace App\Http\Controllers;
use App\Events\PengajuanDiajukan;
use App\Models\LemariModel;
use App\Models\RakModel;
use App\Models\SubKategoriModel;
use Illuminate\Support\Facades\Auth;
use App\Models\ArsipModel;
use App\Models\KategoriModel;
use App\Models\PengajuanModel;
use App\Models\TujuanModel;
use App\Models\TypeModel;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\CustomNotification;

use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    
    public function index()
    {   
        $data['xxx'] = DB::table('arsip')
            ->leftJoin('pengajuan', function ($join) {
                $join->on('arsip.nama', '=', 'pengajuan.nama')
                    ->whereNotNull('pengajuan.approved_at') // Hanya pengajuan yang sudah disetujui
                    ->where('pengajuan.user_id', auth()->user()->id);
            })
            ->leftJoin('subkategori', 'subkategori.id', '=', 'arsip.subkategori')
            ->leftJoin('kategori', 'kategori.id', '=', 'subkategori.kategori')
            ->select(
                'arsip.*',
                // 'arsip.id as pengajuan',
                'pengajuan.id as pengajuan_id',
                'kategori.nama as kategori_nama', 
                'subkategori.nama as sub_nama',
                'pengajuan.approved_at', // Untuk validasi peminjaman
                'pengajuan.status as statups_pengajuan', // Tambahkan ini
                'pengajuan.jenis_arsip',
                'pengajuan.status as status_pengajuan', // Tambahkan ini

            )
            ->where('arsip.jenis_file', 'digital')
            ->orderBy('arsip.created_at', 'desc')
            ->get();

            // return $data['xxx'];
            $data['kategori'] = KategoriModel::get();
            $data['subkategori'] = SubKategoriModel::get();
    

        $data['vvv'] = DB::table('arsip')
            ->leftJoin('pengajuan', function ($join) {
                $join->on('arsip.nama', '=', 'pengajuan.nama')
                    ->whereNotNull('pengajuan.approved_at') // Hanya pengajuan yang sudah disetujui
                    ->where('pengajuan.user_id', auth()->user()->id);
            })
            ->leftJoin('subkategori', 'subkategori.id', '=', 'arsip.subkategori')
            ->leftJoin('kategori', 'kategori.id', '=', 'subkategori.kategori')
            ->select(
                'arsip.*',
                'kategori.nama as kategori_nama', 
                'subkategori.nama as sub_nama',
                'pengajuan.approved_at', // Untuk validasi peminjaman
                'pengajuan.status as statups_pengajuan', // Tambahkan ini
                'pengajuan.jenis_arsip',
                'pengajuan.status as status_pengajuan', // Tambahkan ini

            )
            ->where('arsip.jenis_file', 'fisik')
            ->get();

            // return $data['xxx'];
    
        // Ambil data tambahan untuk form
        $data['lemari'] = LemariModel::get();
        $data['tujuan'] = TujuanModel::get();
        $data['kategori'] = KategoriModel::get();
        $data['subkategori'] = SubKategoriModel::get();
        // $data['pengajuan'] = PengajuanModel::get(); 

    
        return view('user.pengajuan.index', $data);
    }

    public function indexpengajuanfisik()
    {
        $data['ttt'] = DB::table('arsip')
        ->leftJoin('pengajuan', function ($join) {
            $join->on('arsip.nama', '=', 'pengajuan.nama')
                ->whereNotNull('pengajuan.approved_at') // Hanya pengajuan yang sudah disetujui
                ->where('pengajuan.user_id', auth()->user()->id);
        })
        ->leftJoin('subkategori', 'subkategori.id', '=', 'arsip.subkategori')
        ->leftJoin('kategori', 'kategori.id', '=', 'subkategori.kategori')
        ->select(
            'arsip.*',
            'kategori.nama as kategori_nama', 
            'subkategori.nama as sub_nama',
            'pengajuan.approved_at', // Untuk validasi peminjaman
            'pengajuan.status as statups_pengajuan', // Tambahkan ini
            'pengajuan.jenis_arsip',
            'pengajuan.status as status_pengajuan', // Tambahkan ini

        )
        ->where('arsip.jenis_file', 'fisik')
        ->get();

        // return $data['xxx'];

    // Ambil data tambahan untuk form
    $data['lemari'] = LemariModel::get();
    $data['tujuan'] = TujuanModel::get();
    $data['kategori'] = KategoriModel::get();
    $data['subkategori'] = SubKategoriModel::get();

    return view('user.pengajuan.index', $data);
    }

    
    
    


    public function store(Request $request)
    
    {
        // return $request->all();


        // Cek apakah digital atau fisik
        if ($request->jenis_arsip === 'digital') {
            $pengajuan = new PengajuanModel();
            $pengajuan->user_id = Auth::id();
            $pengajuan->nama = $request->namaxxx;
            $pengajuan->type = $request->typexxx;
            $pengajuan->subkategori_id = $request->subkategori;
            $pengajuan->tujuan = $request->tujuanxxx;
            $pengajuan->jenis_arsip = 'digital';
            $pengajuan->status = 'pending'; // Digital langsung disetujui
            $pengajuan->save();
        } elseif ($request->jenis_arsip === 'fisik') {
            $pengajuan = new PengajuanModel();
            $pengajuan->user_id = Auth::id();
            $pengajuan->lemari = $request->lemari;
            $pengajuan->rak = $request->rak;
            $pengajuan->no = $request->no;
            $pengajuan->nama = $request->nama;
            $pengajuan->type = $request->type;
            $pengajuan->tujuan = $request->tujuan;
            $pengajuan->jenis_arsip = $request->jenis_arsip;
            $pengajuan->status = 'pending'; // Fisik butuh persetujuan
            $pengajuan->save();
        }

            
        
        return redirect()->back()->with('success', 'Tersimpan dan Pengajuan Dikirmkan Ke Petugas!!.');
    }


    public function menampilkan()
    {
        $pengajuan = DB::table('pengajuan')
            ->leftJoin('users', 'pengajuan.user_id', '=', 'users.id')
            ->leftJoin('arsip', 'pengajuan.nama', '=', 'arsip.nama') // Hubungkan pengajuan ke arsip berdasarkan nama arsip
            ->leftJoin('subkategori', 'pengajuan.subkategori_id', '=', 'subkategori.id') // Menggunakan subkategori_id
            ->leftJoin('kategori', 'subkategori.kategori', '=', 'kategori.id') // Hubungkan subkategori ke kategori
           
           
            ->select(
                'pengajuan.*',
                'arsip.id as arsip_id', 
                'arsip.nama as arsip_nama',
                'kategori.nama as kategori_nama', 
                'subkategori.nama as sub_nama'
            )
            ->where('pengajuan.user_id', auth()->user()->id) // Hanya data user yang login
            ->orderBy('pengajuan.created_at', 'desc')
            ->get();
          
    
        return view('user.pengajuan.indexpengajuan', compact('pengajuan'));
    }
    




    public function approve($id)    
    {
        $pengajuan = PengajuanModel::findOrFail($id);
        $pengajuan->status = 'approved'; // Ubah status jadi "Disetujui"
        $pengajuan->approved_at = Carbon::now(); // Simpan waktu persetujuan
        $pengajuan->save();

        return redirect()->back()->with('success', 'Pengajuan telah disetujui.');
    }





    public function preview($id) {
        $data['xxx'] = ArsipModel::leftJoin('pengajuan', 'arsip.nama', '=', 'pengajuan.nama')
            ->select('arsip.*', 'pengajuan.status as status_pengajuan')
            ->where('arsip.id', $id) // Ambil hanya data dengan ID tertentu
            ->firstOrFail(); // Mengambil satu data atau error jika tidak ada
    
        return view('user.pengajuan.previewfile', $data);
    }

 
 
}