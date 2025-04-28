<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class KategoriController extends Controller
{
    public function index()
    {
        // $data = [
        //     'kategori_kode' => 'SNK', 
        //     'kategori_nama' => 'Snack/Makanan Ringan',
        //     'created_at' => now()
        // ];
        // DB::table('m_kategori')->insert($data);
        // return "Insert data baru berhasil";

        // Modifikasi untuk update data
        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama'=>'Cemilan']);
        // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row.' baris';

        // Modifikasi untuk menghapus data
        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' .$row.' baris';

        // Modifikasi untuk menampilkan data
        // $data = DB::table('m_kategori')->get();
        // return view('kategori', ['data' => $data]);
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang tersedia'
        ];

        $activeMenu = 'kategori';
        $kategori = KategoriModel::all();
        $authUser = auth()->user();

        return view('kategori.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori', 'authUser'));
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $activeMenu = 'kategori';

        return view('kategori.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:2|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100'
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function show(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.edit', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:2|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100'
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terkait dengan data lain');
        }
    }

    public function list(Request $request)
    {
        $data = KategoriModel::select(['kategori_id', 'kategori_kode', 'kategori_nama']);

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . url('kategori/' . $row->kategori_id) . '" class="btn btn-sm btn-info">Detail</a> ';
                // $btn .= '<a href="' . url('kategori/' . $row->kategori_id . '/edit') . '" class="btn btn-sm btn-warning">Edit</a> ';
                // $btn .= '<form method="POST" action="' . url('kategori/' . $row->kategori_id) . '" style="display:inline;" onsubmit="return confirm(\'Yakin ingin menghapus?\');">'
                //     . csrf_field()
                //     . method_field('DELETE')
                //     . '<button type="submit" class="btn btn-sm btn-danger">Hapus</button>'
                //     . '</form>';
                // $btn = '<button onclick="modalAction(\'' . url('/kategori/' . $row->kategori_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $row->kategori_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $row->kategori_id . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_kode', 'kategori_nama')->get();

        return view('kategori.create_ajax')->with('kategori', $kategori);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|min:3|unique:m_level,level_kode',
                'kategori_nama' => 'required|string|max:255',
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            KategoriModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);
        // $kategori = KategoriModel::select('kategori_kode', 'kategori_nama')->get();

        // Kirim data user & level ke view
        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
                'kategori_nama' => 'required|string|max:255',
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,    // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()  // menunjukkan field mana yang error
                ]);
            }

            $check = KategoriModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    // Jobsheet 6 praktikum 3 nomor 5
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $level = KategoriModel::find($id);
            if ($level) {
                $level->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function import()
    {
        return view('kategori.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_kategori' => ['required', 'mimes:xlsx', 'max:1024'], // validasi file
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_kategori');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'kategori_kode' => $value['A'],
                            'kategori_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    KategoriModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport',
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        $kategori = KategoriModel::select('kategori_kode', 'kategori_nama')->get();
    
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Tambahkan header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Kategori');
        $sheet->setCellValue('C1', 'Nama Kategori');
    
        // Buat header tebal
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
    
        // Tambahkan data dengan nomor urut
        $row = 2;
        $no = 1; // Variabel untuk nomor urut
        foreach ($kategori as $item) {
            $sheet->setCellValue('A' . $row, $no); // Tambahkan nomor urut
            $sheet->setCellValue('B' . $row, $item->kategori_kode);
            $sheet->setCellValue('C' . $row, $item->kategori_nama);
            $row++;
            $no++; // Increment nomor urut
        }
    
        // Sesuaikan lebar kolom
        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        // Simpan file Excel
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Kategori_' . date('Y-m-d_H-i-s') . '.xlsx';
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $kategori = KategoriModel::select('kategori_kode', 'kategori_nama')->get();

        // use Barryvdh\DomPDF\Facade\Pdf
        $pdf = Pdf::loadView('kategori.export_pdf', ['kategori' => $kategori]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data_Kategori_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
