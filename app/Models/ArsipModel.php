<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArsipModel extends Model
{
    use HasFactory;
    protected $table = "arsip";
    protected $fillable = [
        'file',
        'kode',
        'nama',
        'subkategori',
        'deskripsi',
        'lemari',
        'rak',
        'no',
        'jenis_file',
        'size',
       
    ];
}
