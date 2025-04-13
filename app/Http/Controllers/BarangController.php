<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BarangModel;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang tersedia'
        ];

        $activeMenu = 'barang';

        $barang = BarangModel::all();

        return view('barang.index', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah barang baru'
        ];

        $activeMenu = 'barang';

        $kategori = BarangModel::all();

        return view('barang.create', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|min:2|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric'
        ]);

        BarangModel::create($request->all());

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    public function show(string $id)
    {
        $barang = BarangModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', compact('breadcrumb', 'page', 'barang', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $barang = BarangModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit barang'
        ];

        $activeMenu = 'barang';

        $kategori = BarangModel::all();

        return view('barang.edit', compact('breadcrumb', 'page', 'barang', 'activeMenu', 'kategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|min:2|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric'
        ]);

        BarangModel::find($id)->update($request->all());

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = BarangModel::find($id);
        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terkait dengan data lain');
        }
    }

    public function list(Request $request)
    {
        $data = BarangModel::with('kategori')->select(['barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual']);

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('kategori_nama', function ($row) {
                return $row->kategori->kategori_nama ?? '-';
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . url('barang/' . $row->barang_id) . '" class="btn btn-sm btn-info">Detail</a> ';
                $btn .= '<a href="' . url('barang/' . $row->barang_id . '/edit') . '" class="btn btn-sm btn-warning">Edit</a> ';
                $btn .= '<form method="POST" action="' . url('barang/' . $row->barang_id) . '" style="display:inline;" onsubmit="return confirm(\'Yakin ingin menghapus?\');">'
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button type="submit" class="btn btn-sm btn-danger">Hapus</button>'
                    . '</form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
