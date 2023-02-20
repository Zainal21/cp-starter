@extends('layouts.app')
@section('title', 'Create Roles')
@section('content')
    <div class="section-header">
        <h1>Tambah Role</h1>
    </div>
    <div class="card shadow card-body">
        <form action="{{ route('roles.store') }}" method="POST">
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
    </script>
@endpush
