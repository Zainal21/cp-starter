@extends('layouts.app')
@section('title', 'Pengguna')
@section('content')
    <div class="section-header">
        <h1>Pengguna</h1>
    </div>
    <div class="d-flex justify-content-between align-items-start mb-2">
        <h2 class="section-title m-0 mb-4">
            Data Pengguna
        </h2>
        <button class="btn btn-primary">Tambah Pengguna Baru</button>
    </div>
    <div class="card shadow card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table-user">
                <thead>
                    <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@include('components.data-table')
