@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @if (empty($level)) <!-- Change from $user to $level -->
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $level->level_id }}</td> <!-- Corrected syntax for accessing level_id -->
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>{{ $level->level_kode }}</td> <!-- Corrected syntax for accessing level_kode -->
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $level->level_nama }}</td> <!-- Corrected syntax for accessing nama_level -->
                    </tr>
                </table>
            @endif
            <a href="{{ url('level') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush