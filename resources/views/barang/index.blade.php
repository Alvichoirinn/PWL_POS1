@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
                <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-sm btn-success mt-1">TambahAjax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori Nama</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }
        var dataLevel;
        $(document).ready(function () {
            dataUser = $('#table_barang').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    url: "{{ url('barang/list') }}",
                    type: "POST"
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kategori_nama', // tampilkan nama kategori, bukan ID
                        className: ''
                    },
                    {
                        data: 'barang_kode',
                        className: ''
                    },
                    {
                        data: 'barang_nama',
                        className: ''
                    },
                    {
                        data: 'harga_beli',
                        className: 'text-right',
                    },
                    {
                        data: 'harga_jual',
                        className: 'text-right'
                    },
                    {
                        data: 'aksi',
                        className: '',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush