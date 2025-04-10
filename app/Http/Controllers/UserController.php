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
        // $user = UserModel::where('username', 'manager9')->firstOrFail();
        // return view('user', ['data' => $user]);

        // Jobsheet 4 (2.3 Retreiving Aggregrates)
        // $user = UserModel::where('level_id', 2)->count();
        // //dd($user); <--- artinya Dump and Die → jadi semua kode setelah dd() tidak akan dijalankan 
        // return view('user', ['data' => $user]);

        // Jobsheet 4 (2.4 Retreiving or Creating Models)
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ],
        // );
        // return view('user', ['data' => $user]);

        // Modifikasi nomor 4
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22', 
        //         'nama' => 'Manager Dua Dua', 
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2,
        //     ],
        // );
        // return view('user', ['data' => $user]);

        // Modifikasi nomor 6
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ],
        // );
        // return view('user', ['data' => $user]);

        // Modifikasi nomor 8
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2,
        //     ],
        // );
        // return view('user', ['data' => $user]);

        // Modifikasi nomor 10 (Output error karena ada duplikasi data)
        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2,
        //     ],
        // );
        // $user->save();
        // return view('user', ['data' => $user]);

        // Jobsheet 4 (2.5 Attribute Changes)
        // $user = UserModel::create(
        //     [
        //         'username' => 'manager55',
        //         'nama' => 'Manager55',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2,
        //     ]);

        //     $user->username = 'manager56';

        //     $user->isDirty(); //true
        //     $user->isDirty('username'); //true
        //     $user->isDirty('name'); //false
        //     $user->isDirty(['nama', 'username']); //true

        //     $user->isClean(); //false
        //     $user->isClean('username'); //false
        //     $user->isClean('nama'); //true
        //     $user->isClean(['nama', 'username']); //false

        //     $user->save();

        //     $user->isDirty(); //false
        //     $user->isClean(); //true
        //     dd($user->isDirty()
        // ); 

        // Modifikasi nomor 3
        $user = UserModel::create([
            'username' => 'manager11',
            'nama' => 'Manager11',
            'password' => Hash::make('12345'),
            'level_id' => 2,
        ]);

        $user->username = 'manager12';
 
        $user->save();

        $user->wasChanged(); //true
        $user->wasChanged('username'); //true
        $user->wasChanged(['username', 'level_id']); //true
        $user->wasChanged('name'); //false
        dd($user->wasChanged(['nama', 'username'])); //true
    }
}
