<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\SupplierModel;

class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Supplier',
            'list' => ['Home', 'Supplier']
        ];

        $page = (object)[
            'title' => 'Daftar Supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah supplier baru'
        ];

        $activeMenu = 'supplier';

        return view('supplier.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_kode' => 'required|unique:m_supplier,supplier_kode',
            'supplier_nama' => 'required',
            'supplier_alamat' => 'required',
            'supplier_telp' => 'required',
        ]);

        SupplierModel::create($request->all());

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }

    public function show(string $id)
    {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.show', compact('breadcrumb', 'page', 'supplier', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Supplier',
            'list' => ['Home', 'Supplier', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.edit', compact('breadcrumb', 'page', 'supplier', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_kode' => 'required|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
            'supplier_nama' => 'required',
            'supplier_alamat' => 'required',
            'supplier_telp' => 'required',
        ]);

        SupplierModel::find($id)->update($request->all());

        return redirect('/supplier')->with('success', 'Data supplier berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $supplier = SupplierModel::find($id);
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            SupplierModel::destroy($id);
            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/supplier')->with('error', 'Data gagal dihapus karena masih digunakan');
        }
    }

    public function list(Request $request)
    {
        $data = SupplierModel::select(['supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . url('supplier/' . $row->supplier_id) . '" class="btn btn-sm btn-info">Detail</a> ';
                $btn .= '<a href="' . url('supplier/' . $row->supplier_id . '/edit') . '" class="btn btn-sm btn-warning">Edit</a> ';
                $btn .= '<form method="POST" action="' . url('supplier/' . $row->supplier_id) . '" style="display:inline;" onsubmit="return confirm(\'Yakin ingin menghapus?\');">'
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
