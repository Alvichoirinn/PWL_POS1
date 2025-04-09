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
        for ($i = 1; $i <= 10; $i++) { 
            $data[] = [
                'stok_id' => $i,
                'supplier_id' => ceil($i / 5),
                'barang_id' => $i,
                'user_id' => 1, // Stok dimasukkan oleh Admin (user_id = 1)
                'stok_tanggal' => Carbon::now()->subDays(rand(1, 30)),
                'stok_jumlah' => rand(10, 100), // Stok acak antara 10 - 100
            ];
        }
        DB::table('t_stok')->insert($data);
    }
}
