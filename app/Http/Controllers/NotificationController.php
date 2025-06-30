<?php

namespace App\Http\Controllers;
use App\Models\PengajuanModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = Auth::user();
    
        // Cek apakah user memiliki role 0 atau 1, hanya mereka yang bisa menerima notifikasi
        if ($user->role == 0 || $user->role == 1) {
            // Ambil permintaan yang statusnya pending
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
    
            // Mengembalikan data notifikasi dalam format JSON
            return response()->json($permintaanapprove);
        }
    
        // Jika role bukan 0 atau 1, kirimkan response kosong
        return response()->json([]);
    }
    

}
