<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    use HasFactory;

    protected $table = 'm_kategori'; // Nama tabel di database

    protected $primaryKey = 'kategori_id'; // Primary key-nya

    public $timestamps = false; // Kalau tabel tidak punya kolom created_at dan updated_at

    protected $fillable = [
        'kategori_kode',
        'kategori_nama',
    ];
}
