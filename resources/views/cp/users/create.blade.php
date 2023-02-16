@extends('layouts.main')
@section('title', 'Tambah Data Pengguna')
@section('content')
<div class="section-header">
  <h1>Tambah Pengguna</h1>
</div>
<div class="card shadow card-body">
  <form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="name">Name</label>
      <input
        type="text"
        id="name"
        class="form-control @error('name') is-invalid @enderror"
        name="name"
        autofocus=""
        value="{{old('name')}}"
      />
      @error('name')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="username">Username</label>
      <input
        type="text"
        id="username"
        class="form-control @error('username') is-invalid @enderror"
        name="username"
        value="{{old('username')}}"
      />
      @error('name')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input
        type="email"
        id="email"
        class="form-control @error('email') is-invalid @enderror"
        name="email"
        autofocus=""
        value="{{old('email')}}"
      />
      @error('email')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="form-group">
      <label>Role</label>
      <select name="roles" id="" class="form-control select2 @error('roles') is-invalid @enderror">
        <option disabled selected>Pilih role</option>
        @foreach ($roles as $role)
          <option value="{{ $role->name }}">{{ $role->name }}</option>
        @endforeach
      </select>
      @error('roles')
      <div class="text-danger">
        {{ $message }}
      </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('users.index')}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin untuk meninggalkan halaman ini ?')">kembali</a>
  </form>
</div>
@endsection