@extends('layouts.app')
@section('title', 'Edit Roles')
@section('content')
    <div class="section-header">
        <h1>Edit Role</h1>
    </div>
    <div class="card shadow card-body">
        <form action="{{ route('roles.update', $role->id) }}" method="POST" id="form-roles-update">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ $role->name }}" autofocus="" />
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group form-check">
                <div class="row">
                    @foreach ($permission as $value)
                        <div class="col-md-4">
                            <div class="control-label">{{ $value->general_name }}</div>
                            <label class="custom-switch mt-2">
                                {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'custom-switch-input']) }}
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('roles.index') }}" class="btn btn-danger"
                onclick="return confirm('Apakah anda yakin untuk meninggalkan halaman ini ?')">kembali</a>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
       $('#form-roles-update').on('submit', function(e){
        e.preventDefault()
        Swal.fire({
                title: 'Apakah anda yakin?',
                text: "untuk mengubah data tersebut!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ubah Sekarang!'
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxRequest($(this).serialize(), $(this).attr('action'), 'PUT')
                        .then(({
                            message
                        }) => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: message,
                                icon: 'success',
                            }).then(() => {
                                window.location.href = "{{route('roles.index')}}"
                            })
                        })
                        .catch((e) => {
                            if (typeof(e.responseJSON.message) == 'object') {
                                let textError = '';
                                $.each(e.responseJSON.message, function(key, value) {
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
                }
            })
       })
    </script>
@endpush