<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\UserModel;
use App\Models\LevelModel; // Pastikan LevelModel sudah ada

class ProfileController extends Controller
{
    // Menampilkan halaman edit profil
    public function edit()
    {
        $user = UserModel::with('level')->find(Auth::id()); // ambil user + level relasinya

        $breadcrumb = (object) [
            'title' => 'Edit Profil',
            'list' => ['Dashboard', 'Edit Profil'],
        ];

        $activeMenu = 'profile';

        return view('profile.edit', compact('user', 'breadcrumb', 'activeMenu'));
    }

    // Mengupdate data profil
    public function update(Request $request)
    {
        try {
            $user = UserModel::findOrFail(Auth::id());

            // Validasi input
            $request->validate([
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nama' => 'required|string|max:255',
                'username' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('m_user', 'username')->ignore($user->user_id, 'user_id'),
                ],
            ]);

            // Update nama dan username
            $user->nama = $request->nama;
            $user->username = $request->username;

            // Cek jika ada upload foto baru
            if ($request->hasFile('foto')) {
                // Hapus foto lama kalau ada
                if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                    Storage::disk('public')->delete($user->foto);
                }

                // Upload foto baru
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads/foto', $filename, 'public');

                $user->foto = $path;
            }

            // Simpan perubahan
            $user->save();

            return response()->json([
                'success' => true,
                'foto_url' => asset('storage/' . $user->foto),
                'nama' => $user->nama,
                'username' => $user->username,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
