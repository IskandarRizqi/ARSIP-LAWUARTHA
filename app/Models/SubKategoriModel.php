<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubKategoriModel extends Model
{
    use HasFactory;
    protected $table = "subkategori";
    protected $fillable = [
        'nama',
        'kategori',
    ];
}
