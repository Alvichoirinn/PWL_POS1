<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'm_supplier';
    protected $primaryKey = 'supplier_id';
    public $timestamps = false; // karena kolom created_at & updated_at bernilai NULL dan tidak digunakan

    protected $fillable = [
        'supplier_kode',
        'supplier_nama',
        'supplier_alamat',
    ];
}
