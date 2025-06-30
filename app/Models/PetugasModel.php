<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PetugasModel extends Model
{
    use HasFactory;
    protected $table = "petugas";
    protected $fillable = [
        'gambar',
        'nama',
        'username',
        'password',
        'jabatan',
       
    ];
}
