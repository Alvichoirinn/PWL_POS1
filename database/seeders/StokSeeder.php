<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) { // Hanya membuat 10 data stok 
            $data[] = [
                'stok_id' => $i,
                'barang_id' => $i, // Menggunakan 10 pertama
                'user_id' => 1, // Stok dimasukkan oleh Admin (user_id = 1)
                'stok_tanggal' => Carbon::now()->subDays(rand(1, 30)),
                'stok_jumlah' => rand(10, 100), // Stok acak antara 10 - 100
            ];
        }
        DB::table('t_stok')->insert($data);
    }
}
