@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('supplier/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_supplier">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Alamat Supplier</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#table_supplier').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('supplier/list') }}",
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
                        data: 'supplier_kode',
                        className: ''
                    },
                    {
                        data: 'supplier_nama',
                        className: ''
                    },
                    {
                        data: 'supplier_alamat',
                        className: ''
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