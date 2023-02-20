@extends('layouts.app')
@section('title', 'Roles')
@section('content')
<div class="section-header">
    <h1>Role</h1>
</div>
<div class="d-flex justify-content-between align-items-start mb-2">
    <h2 class="section-title m-0 mb-4">
        Data Role
    </h2>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">Tambah Role Baru</a>
</div>
<div class="card shadow card-body">
    @include('components.flash-message')
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="table-role">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>Nama Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a href="{{ route('roles.show', Crypt::encrypt($role->id)) }}" class="btn btn-info"
                            data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i
                                class="fas fa-eye"></i></a>
                        <a href="{{ route('roles.edit', Crypt::encrypt($role->id)) }}" class="btn btn-primary"
                            data-toggle="tooltip" data-placement="top" title="Ubah Data"><i
                                class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@include('components.data-table')
