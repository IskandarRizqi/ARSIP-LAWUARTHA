<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LemariModel extends Model
{
    use HasFactory;
    protected $table = "lemari";
    protected $fillable = [
        'nama',
      
    ];
}
