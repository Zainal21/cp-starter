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
        <div class="row">
            @foreach ($permission as $value)
                <div class="col-md-4">
                    <div class="control-label">{{ $value->general_name }}</div>
                    <label class="custom-switch mt-2">
                        {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'custom-switch-input', 'disabled']) }}
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-3 my-2">
                <a href="{{ route('roles.index') }}" class="btn btn-danger">kembali</a>
            </div>
        </div>
    </div>
@endsection
