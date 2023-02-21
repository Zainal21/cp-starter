@extends('layouts.app')
@section('title', 'Create Roles')
@section('content')
    <div class="section-header">
        <h1>Tambah Role</h1>
    </div>
    <div class="card shadow card-body">
        <form action="{{ route('roles.store') }}" method="POST" id="form-roles">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                    autofocus="" value="{{ old('name') }}" />
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
                                <input type="checkbox" name="permission[]" checked="false"
                                    onchange="handleChange(`{{ $value->id }}`)" class="custom-switch-input"
                                    id="input-{{ $value->id }}" value="{{ $value->id }}">
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
        const handleChange = (id) => {
            if($('#input-'.id).is(':checked')){
                $('#input-'.id).prop('checked', true)
            }else{
                $('#input-'.id).prop('checked', false)
            }
        }

        $(document).ready(function(){
            $('#form-roles').on('submit', function(e){
                e.preventDefault();
                ajaxRequest($(this).serialize(), $(this).attr('action'), 'POST')
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
                    }).catch((e) => {
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
            });
        })
    </script>
@endpush
