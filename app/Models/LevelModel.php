<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
class LevelModel extends Model
    {
    use HasFactory;
 
    protected $table = 'm_level'; // Pastikan tabelnya sesuai dengan database
    protected $primaryKey = 'level_id'; // pastikan ini sesuai dengan kolom primary key di tabel
    public $timestamps = false; // karena tidak pakai updated_at dan created_at bawaan Laravel

    protected $fillable = ['level_kode', 'level_nama', 'created_at']; // untuk mass assignment
 
    public function user(): HasMany
    {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}