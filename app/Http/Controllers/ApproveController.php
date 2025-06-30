<?php

namespace App\Http\Controllers;

use App\Models\PengajuanModel;
use App\Models\SubKategoriModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ApproveController extends Controller
{

    public function index()
    {   

        $pengajuan = DB::table('pengajuan')
        ->leftJoin('users', 'users.id', '=', 'pengajuan.user_id') 
        ->leftJoin('arsip', 'arsip.nama', '=', 'pengajuan.nama') // Hubungkan pengajuan ke arsip berdasarkan nama arsip
        ->leftJoin('subkategori', 'pengajuan.subkategori_id', '=', 'subkategori.id') // Menggunakan subkategori_id
        ->leftJoin('kategori', 'subkategori.kategori', '=', 'kategori.id') // Hubungkan subkategori ke kategori
 
        ->select(
                'pengajuan.*',
                'users.name as user_name',
                'pengajuan.nama as nama',
                'pengajuan.jenis_arsip',
                'pengajuan.type',
                'kategori.nama as kategori_nama', 
                'subkategori.nama as sub_nama',
                'pengajuan.tujuan',
                'pengajuan.status',   
                'pengajuan.approved_at', // Waktu persetujuan
                // 'arsip.nama as nama_arsip',
           
        )
        ->orderBy('pengajuan.created_at', 'desc')
        ->get();

        // return $pengajuan;

        return view('pages.approval.index', compact('pengajuan'));

    }
    
    
    public function approve($id)
    {
        $pengajuan = PengajuanModel::findOrFail($id);
        $pengajuan->status = 'approved'; // Ubah status menjadi "Disetujui"
        $pengajuan->approved_at = Carbon::now();
        $pengajuan->approved_by = auth()->user()->id; // Simpan ID petugas yang approve
        $pengajuan->rejected_by = null; // Kosongkan jika sebelumnya ditolak
        // Tetapkan batas pengembalian selalu pukul 15:00 hari ini
        $pengajuan->due_date = Carbon::now()->setTime(15, 0, 0);

        $pengajuan->save();
    
        return redirect()->route('approvals.index')->with('success', 'Peminjaman telah disetujui.');
    }

    public function reject($id)
    {
        $pengajuan = PengajuanModel::findOrFail($id);
        $pengajuan->status = 'rejected'; // Ubah status menjadi "Ditolak"
        $pengajuan->rejected_at = Carbon::now();
        $pengajuan->approved_by = null; // Kosongkan jika sebelumnya disetujui
        $pengajuan->rejected_by = auth()->user()->id; // Simpan ID user yang menolak
        $pengajuan->save();

        return redirect()->route('approvals.index')->with('success', 'Peminjaman telah ditolak.');
    }
    public function return($id)
    {
        // return $id;
        $pengajuan = PengajuanModel::findOrFail($id);
        $pengajuan->jenis_arsip == 'fisik'; // Ubah status menjadi "Ditolak"
        $pengajuan->status = 'returned';
        $pengajuan->returned_at = Carbon::now();$pengajuan->returned_at = Carbon::now(); // Simpan waktu pengembalian
      
        $pengajuan->save();

        return redirect()->route('approvals.index')->with('success', 'Peminjaman Sudah Dikembalikan.');
    }



    

}
