<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanModel extends Model
{
    protected $table = "pengajuan";
    protected $fillable = [
        'nama',
        'type',
        'subkategori_id',
        'arsip_id',
        'tujuan',
        'lemari',
        'rak',
        'no',
        'status',
        'approve_at',
        'rejected_at',
        'jenis_arsip',
        'returned_at',
        'due_date',
        'downloaded_by',
        'downloaded_at',
        'user_id'
    
       
    ];
}
