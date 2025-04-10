<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        // Coba akses model User Model 
        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // Modifikasi untuk menambahkan data user dengan Eloquent Model
        // $data = [
        //     'username' => 'customer-1',
        //     'nama' => 'Pelanggan',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 4
        // ];
        // UserModel::insert($data);

        // Modifikasi untuk update data 
        // $data = [
        //     'nama' => 'Pelanggan Pertama',
        // ];
        // UserModel::where('Username', 'customer-1')->update($data);

        // Jobsheet 4 (Manambahkan data baru)
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_dua',
        //     'nama' => 'Manager 2',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // // Coba akses model user model 
        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // Jobsheet 4 (2.1 Retrieving Single Model)
        // $user = UserModel::find(1);
        // return view('user', ['data' => $user]);

        // Modifikasi nomor 4
        // $user = UserModel::where('level_id', 1)->first();
        // return view('user', ['data' => $user]);

        // Modifikasi nomor 6
        // $user = UserModel::firstWhere('level_id', 1);
        // return view('user', ['data' => $user]);

        // Modifikasi nomor 8
        // $user = UserModel::findOr(20,['username', 'nama'], function(){
        //     abort(404);
        // });
        // return view('user', ['data' => $user]);

        // Jobsheet 4 (2.2 Not Found Exceptions)
        // $user = UserModel::findOrFail(1);
        // return view('user', ['data' => $user]);

        // Modifikasi nomor 3
        $user = UserModel::where('username', 'manager9')->firstOrFail();
        return view('user', ['data' => $user]);
    }
}
