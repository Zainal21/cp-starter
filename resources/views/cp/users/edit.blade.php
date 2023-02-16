@extends('layouts.main')
@section('title', 'Tambah Data Pengguna')
@section('content')
<div class="section-header">
  <h1>Ubah Role {{ $user->name }}</h1>
</div>
<div class="card shadow card-body">
  <form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label>Role</label>
      {{-- {!! Form::select('roles', $roles,[], array('class' => 'form-control')) !!} --}}
      <select name="roles" id="" class="form-control select2 @error('roles') is-invalid @enderror">
        @foreach ($roles as $role)
          <option value="{{ $role->name }}" {{ $role->name === $user->getRoleNames()[0] ? 'selected' : '' }}>{{ $role->name }}</option>
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