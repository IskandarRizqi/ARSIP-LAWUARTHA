<?php
  
namespace App\Http\Controllers;
use App\Models\ArsipModel;
use App\Models\KategoriModel;
use App\Models\PengajuanModel;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Model untuk user
use Illuminate\Support\Facades\Log;
use DB;
use Carbon\Carbon;
  
use Illuminate\Http\Request;
  
class HomeController extends Controller
{

    public function index() {
        // Dapatkan pengguna yang sedang login
        $user = Auth::user();
    
        // Jika pengguna belum login, arahkan ke halaman login
        if (!$user) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Hitung total arsip, kategori, petugas, dan user
        $totalArsip = ArsipModel::where('jenis_file', 'digital')->count();
        $totalKategori = KategoriModel::count();
        $totalPetugas = User::where('role', 1)->count();
        $totalUser = User::where('role', 2)->count();
        $totalPimpinan = User::where('role', 0)->count(); // Menghitung user dengan role = 0 (pimpinan)
  
    

    
    
        // PIMPINAN
        $storagePerMonth = ArsipModel::selectRaw('EXTRACT(MONTH FROM created_at) as bulan, SUM(size) as total_size')
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total_size', 'bulan')
        ->toArray();

        // Pastikan array memiliki nilai untuk semua bulan (1-12)
        $formattedData = [];
        for ($i = 1; $i <= 12; $i++) {
            // Kalau DB simpan dalam KB, maka butuh /1024 dua kali (KB -> MB -> GB)
            $formattedData[] = isset($storagePerMonth[$i]) 
                ? round(($storagePerMonth[$i] / 1024) / 1024, 1) 
                : 0;
        }

        

        

        $fileTerbesar = ArsipModel::whereNotNull('size')
        ->where('size', '>', 0)
        ->orderBy('size', 'desc')
        ->limit(6)
        ->get();


        $filePalingDiakses = PengajuanModel::where('status', 'approved')
        ->selectRaw('nama, COUNT(*) as total_akses') // Ambil nama file dan hitung jumlah akses
        ->groupBy('nama')
        ->orderByDesc('total_akses')
        ->limit(6)
        ->get();

        if ($user->role == 0) { // Jika user adalah pimpinan
            $userSeringMengakses = PengajuanModel::where('status', 'approved')
                ->selectRaw('user_id, COUNT(*) as total_akses')
                ->groupBy('user_id')
                ->orderByDesc('total_akses')
                ->limit(6)
                ->get();
        
            // Ambil nama user berdasarkan user_id
            foreach ($userSeringMengakses as $data) {
                $pengguna = User::find($data->user_id);
                $data->nama_user = $pengguna ? $pengguna->name : 'Unknown User';
            }
        } else {
            $userSeringMengakses = collect([]); // Jika bukan pimpinan, buat collection kosong
        }

        if ($user->role == 0 || $user->role == 1) { // Jika user adalah pimpinan atau petugas
            $permintaanapprove = PengajuanModel::where('status', 'pending')
                ->selectRaw('user_id, COUNT(*) as total_akses')
                ->groupBy('user_id')
                ->orderByDesc('total_akses')
                ->limit(7)
                ->get();
            
            // Ambil nama user berdasarkan user_id
            foreach ($permintaanapprove as $data) {
                $pengguna = User::find($data->user_id);
                $data->nama_user = $pengguna ? $pengguna->name : 'Unknown User';
            }
        } else {
            $permintaanapprove = collect([]); // Jika bukan pimpinan atau petugas, buat collection kosong
        }
        

        $permintaanapproveCount = PengajuanModel::where('status', 'pending')->count();
        



        // PETUGAS 
        $totalPengajuan = PengajuanModel::count();
        $PengajuanblmApp = PengajuanModel::
        where('status', 'pending')
        ->count();

        $approvedPerMonth = PengajuanModel::selectRaw('EXTRACT(MONTH FROM created_at) as bulan, COUNT(*) as total')
        ->where('status', 'approved')
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

         // Format data untuk Chart.js
        $dataChart = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataChart[] = $approvedPerMonth[$i] ?? 0; // Jika tidak ada data, isi 0
        }




        // USER
        $totalPeminjamanUser = PengajuanModel::where('user_id', $user->id)
        ->where('status', 'approved')
        ->count();
        $totalPeminjamanUserdigital = PengajuanModel::where('user_id', $user->id)
        ->where('jenis_arsip', 'digital')
        ->count();
        $totalPeminjamanUserfisik = PengajuanModel::where('user_id', $user->id)
        ->where('jenis_arsip', 'fisik')
        ->count();
        // Ambil jumlah peminjaman per bulan
        $peminjamanPerBulan = PengajuanModel::selectRaw('EXTRACT(MONTH FROM created_at) as bulan, COUNT(*) as total')
        ->where('user_id', $user->id)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

        $dataPeminjaman = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataPeminjaman[] = $peminjamanPerBulan[$i] ?? 0;
        }
     
        


        // Cek role pengguna dan arahkan ke dashboard yang sesuai
        if ($user->role == 0) {
            return view('dashboard.pimpinan', compact('totalArsip', 'totalKategori', 'totalPetugas', 'totalUser', 'formattedData', 'fileTerbesar', 'filePalingDiakses', 'userSeringMengakses', 'user', 'permintaanapprove','permintaanapproveCount'));
        } elseif ($user->role == 1) {
            return view('dashboard.petugas', compact('totalArsip', 'totalPengajuan', 'PengajuanblmApp', 'totalUser', 'dataChart', 'user', 'permintaanapproveCount','permintaanapprove'));
        } elseif ($user->role == 2) {
            return view('dashboard.user', compact('totalArsip', 'totalPeminjamanUser', 'totalPeminjamanUserdigital', 'totalPeminjamanUserfisik','dataPeminjaman', 'user'));
        } else {
            return redirect('home')->with('error', 'Role tidak dikenali.');
        }
    }

    
    


    
}