<?php

namespace App\Http\Controllers;
use App\Models\ArsipModel;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanModel;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use ZipArchive;
use Illuminate\Support\Str;


class LoghistoryConttroller extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanModel::leftJoin('users as u1', 'pengajuan.user_id', '=', 'u1.id')
        ->leftJoin('users as u2', 'pengajuan.approved_by', '=', 'u2.id')
        ->leftJoin('users as u3', 'pengajuan.rejected_by', '=', 'u3.id')
        ->where('pengajuan.user_id', auth()->user()->id) // Ambil hanya data user yang login
        ->orderBy('pengajuan.created_at', 'desc') // Urutkan dari yang terbaru
        ->select(
            'pengajuan.*',
            'u1.name as user_name',        // Nama pengguna yang mengajukan
            'u2.name as approved_by_name', // Nama petugas yang menyetujui
            'u3.name as rejected_by_name'  // Nama petugas yang menolak
        )
        ->get();

       
        return view('user.loghistory.index', ['pengajuan' => $pengajuan]);

    }

    public function logall()
    {
        $data['pengajuan'] = PengajuanModel::leftJoin('users as u1', 'pengajuan.user_id', '=', 'u1.id')
    ->leftJoin('users as u2', 'pengajuan.approved_by', '=', 'u2.id')
    ->leftJoin('users as u3', 'pengajuan.rejected_by', '=', 'u3.id')
    ->select(
        'pengajuan.*',
        'u1.name as user_name',        // Nama pengguna yang mengajukan
        'u2.name as approved_by_name', // Nama petugas yang menyetujui
        'u3.name as rejected_by_name'  // Nama petugas yang menolak
    )
    ->orderBy('pengajuan.created_at', 'desc')
    ->get();

    return view('user.loghistory.index', $data);

    }

    public function fungsimenuunduh() {
        // Mengambil data pengajuan dengan relasi untuk pengaju dan pengunduh
        $data['arsip'] = DB::table('pengajuan')
            ->leftJoin('users as pengaju', 'pengaju.id', '=', 'pengajuan.user_id') // User yang mengajukan
            ->leftJoin('users as pengunduh', 'pengunduh.id', '=', 'pengajuan.downloaded_by') // User yang mengunduh
            ->select(
                'pengajuan.*',
                'pengajuan.nama as nama_file', // Ambil nama file dari kolom 'nama'
                'pengaju.name as nama_pengaju', // Nama user yang mengajukan
                'pengunduh.name as nama_pengunduh', // Nama user yang mengunduh
                'pengajuan.approved_at as waktu_disetujui',
                'pengajuan.downloaded_at as waktu_unduh'
            )
            ->whereNotNull('pengajuan.approved_at') // Hanya pengajuan yang sudah disetujui
            ->orderBy('pengajuan.approved_at', 'desc')
            ->get();
    
        // Menambahkan relasi pengunduh untuk data pengajuan
        $data['pengajuan'] = PengajuanModel::get(); // Eager load pengunduh
        
        return view('pages.unduh.index', $data);
    }
    
    
    
    
  

    public function downloadFile(Request $request)
    { 
        // return $request->all();
        $arsip = ArsipModel::where('id', $request->arsipid)->first();

        // Cek apakah pengajuan sudah ada
        $pengajuan = PengajuanModel::where('id', $request->pengajuanid)->first();
        
        if ($pengajuan && !$pengajuan->downloaded_at) {
            // Simpan informasi bahwa file telah diunduh
            $pengajuan->update([
                'downloaded_by' => auth()->user()->id,
                'downloaded_at' => Carbon::now(),
            ]);
        }

        return response()->download(public_path('storage/' . $arsip['file']));
    }
    

  public function downloadFileZip(Request $request)
{
    $arsip = ArsipModel::where('id', $request->arsipid)->first();
    $pengajuan = PengajuanModel::where('id', $request->pengajuanid)->first();

    if (!$arsip || !Storage::disk('public')->exists($arsip->file)) {
        return abort(404, 'File tidak ditemukan');
    }

    // Simpan informasi bahwa file telah diunduh
    if ($pengajuan && !$pengajuan->downloaded_at) {
        $pengajuan->update([
            'downloaded_by' => auth()->user()->id,
            'downloaded_at' => Carbon::now(),
        ]);
    }

    // Siapkan path sementara
    $namaZip = 'arsip_' . Str::slug($arsip->nama ?? 'file') . '.zip';
    $zipPath = storage_path('app/temp_zip/' . $namaZip);

    // Buat folder jika belum ada
    if (!file_exists(storage_path('app/temp_zip'))) {
        mkdir(storage_path('app/temp_zip'), 0777, true);
    }

    $zip = new ZipArchive;
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        $filePath = storage_path('app/public/' . $arsip->file);
        $fileName = basename($arsip->file);

        $zip->addFile($filePath, $fileName);
        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    return response()->json(['error' => 'Gagal membuat file ZIP'], 500);
}
    
}

