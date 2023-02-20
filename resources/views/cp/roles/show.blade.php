@extends('layouts.app')
@section('title', 'Show Roles')
@section('content')
    <div class="section-header">
        <h1>Detail Role</h1>
    </div>
    <div class="card shadow card-body">
        <div class="form-group">
            <label for="name">Nama Role</label>
            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                autofocus="" value="{{ $role->name }}" readonly />
        </div>
        @if (!empty($rolePermissions))
            @foreach ($rolePermissions as $items)
                <div class="col-md-4">
                    <div class="control-label">{{ $items->general_name }}</div>
                    <label class="custom-switch mt-2 on">
                        <input type="checkbox" name="permission[]" checked="true" class="custom-switch-input" value="1"
                            disabled>
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>
            @endforeach
        @endif
        <div class="row">
            <div class="col-md-3 my-2">
                <a href="{{ route('roles.index') }}" class="btn btn-danger">kembali</a>
            </div>
        </div>
    </div>
@endsection
