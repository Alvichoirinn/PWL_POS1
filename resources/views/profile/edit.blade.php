@extends('layouts.template')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title">Edit Profil</h4>
            </div>

            <div class="card-body">
                <!-- Form untuk edit profil -->
                <form id="form-update-profile" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center mb-4">
                        <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('adminlte/dist/img/user1-128x128.jpg') }}"
                             class="user-image img-circle elevation-2" alt="{{ $user->nama }}" id="preview-foto-profile"
                             style="width: 150px; height: 150px;">
                    </div>

                    <!-- Input untuk foto profil -->
                    <div class="form-group">
                        <label for="foto">Foto Profil</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                        <div class="invalid-feedback" id="error-foto"></div>
                    </div>

                    <!-- Input untuk nama -->
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $user->nama }}">
                        <div class="invalid-feedback" id="error-nama"></div>
                    </div>

                    <!-- Input untuk username -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="{{ $user->username }}">
                        <div class="invalid-feedback" id="error-username"></div>
                    </div>

                    <!-- Menampilkan level user (hanya read-only) -->
                    <div class="form-group">
                        <label for="level">Level</label>
                        <input type="text" class="form-control" value="{{ $user->level->level_nama ?? '-' }}" readonly>
                    </div>

                    <!-- Tombol untuk simpan perubahan -->
                    <button class="btn btn-primary btn-block" type="submit" id="btn-save">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Handle submit form dengan AJAX
        $('#form-update-profile').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            // Reset error state
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            // Disable tombol dan tampilkan "Menyimpan..."
            $('#btn-save').attr('disabled', true).text('Menyimpan...');

            $.ajax({
                url: "{{ route('profile.update') }}", // URL untuk update profil
                method: "POST", // Menggunakan POST untuk mengupdate data
                data: formData, // Data yang dikirim dalam form
                dataType: "json",
                contentType: false, // Membiarkan browser mengatur konten
                processData: false, // Jangan proses data otomatis
                success: function (response) {
                    $('#btn-save').attr('disabled', false).text('Simpan Perubahan');

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: 'Profil berhasil diperbarui!',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Update foto profil di form dan navbar
                        $('#preview-foto-profile').attr('src', response.foto_url + '?' + new Date().getTime());
                        $('#navbar-foto-profile').attr('src', response.foto_url + '?' + new Date().getTime());

                        // Update nama dan username
                        $('#nama').val(response.nama);
                        $('#username').val(response.username);
                    }
                },
                error: function (xhr, status, error) {
                    $('#btn-save').attr('disabled', false).text('Simpan Perubahan');

                    // Cek error validasi
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#error-' + key).text(value[0]);
                        });
                    } else {
                        // Jika error lainnya
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON.message || 'Terjadi kesalahan saat mengupdate profil!',
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
