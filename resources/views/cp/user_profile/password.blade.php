@extends('layouts.app')
@section('title', 'Ubah Password')
@section('content')
<div class="section-header">
    <h1>Reset Password</h1>
</div>
<div class="section-body">
    <h2 class="section-title">Hi, {{ $user->name }}!</h2>
    <p class="section-lead">
        Ubah informasi tentang diri Anda di halaman ini.
    </p>

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card shadow">
                <form method="post" action="{{ route('user-password.update', $user->id) }}" id="formUpdatePassword">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        @include('components.flash-message')
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label>Password Lama</label>
                                <input type="password" name="currentPassword"
                                    class="form-control @error('currentPassword') is-invalid @enderror" required="" />
                                @error('currentPassword')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Password Baru</label>
                                <input type="password" name="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror" required="" />
                                <span class="form-text text-muted">
                                    Kata sandi Anda harus lebih dari 8 karakter, harus berisi setidaknya 1 Huruf Besar,
                                    1 Huruf Kecil, 1 Angka dan 1 karakter khusus.
                                </span>
                                @error('new_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Konfirmasi Password Terbaru</label>
                                <input type="password" name="confirm-password" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#formUpdatePassword').on('submit', function(e) {
            e.preventDefault();
            let data = $(this).serialize()
            let route = $(this).attr('action')
            ajaxRequest($(this).serialize(), route, 'PUT')
                .then(({
                    message
                }) => {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: message,
                        icon: 'success',
                    }).then(() => {
                        window.location.reload()
                    })
                }).catch((e) => {
                    console.log(e)
                    if (typeof(e.responseJSON.errors) == 'object') {
                        let textError = '';
                        $.each(e.responseJSON.errors, function(key, value) {
                            textError += `${value}<br>`
                        });
                        Swal.fire({
                            title: 'Gagal!',
                            html: textError,
                            icon: 'error',
                        })
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: e.responseJSON.message,
                            icon: 'error',
                        })
                    }

                })
        });
    })
</script>
@endpush
