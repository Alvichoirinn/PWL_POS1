<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Barang untuk Kategori Elektronik
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'ELK001', 'barang_nama' => 'Laptop', 'harga_beli' => 4500000, 'harga_jual' => 5200000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'ELK002', 'barang_nama' => 'Speaker Bluetooth', 'harga_beli' => 300000, 'harga_jual' => 350000],

            // Barang untuk Kategori Makanan & Minuman
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'FOD001', 'barang_nama' => 'Indomie', 'harga_beli' => 2000, 'harga_jual' => 3500],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'FOD002', 'barang_nama' => 'Teh Botol', 'harga_beli' => 4000, 'harga_jual' => 5000],

            // Barang untuk Kategori Furniture
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'FRN001', 'barang_nama' => 'Lemari', 'harga_beli' => 750000, 'harga_jual' => 800000],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'FRN002', 'barang_nama' => 'Meja TV', 'harga_beli' => 600000, 'harga_jual' => 650000],

            // Barang untuk Kategori Pakaian
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'CLT001', 'barang_nama' => 'Kaos Polos', 'harga_beli' => 60000, 'harga_jual' => 70000],
            ['barang_id' => 8, 'kategori_id' => 4, 'barang_kode' => 'CLT002', 'barang_nama' => 'Jaket Hoodie', 'harga_beli' => 120000, 'harga_jual' => 140000],

            // Barang untuk Kategori Olahraga
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'SPT001', 'barang_nama' => 'Bola Basket', 'harga_beli' => 120000, 'harga_jual' => 150000],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'SPT002', 'barang_nama' => 'Raket', 'harga_beli' => 130000, 'harga_jual' => 150000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
