<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'm_barang';

    // Primary key (jika tidak pakai id)
    protected $primaryKey = 'barang_id';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'kategori_id',
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
    ];

    // Relasi ke tabel kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }
}
