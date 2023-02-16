@extends('layouts.app')
@section('title', 'Trash Informasi')
@section('content')
<div class="section-header">
    <h1>Informasi Yang Telah Dihapus</h1>
</div>
<div class="d-flex justify-content-between align-items-start mb-2">
    <h2 class="section-title m-0 mb-4">
        Data Informasi
    </h2>
    @can('trash-post')
    <div class="float-right d-inline">
        <a href="{{ route('post.restore-all') }}" class="btn btn-info mb-3"
            onclick="return confirm('Apakah Anda Yakin Untuk Me-Restore Semua Data Informasi?')"><i
                class="far fa-folder-open"></i> Restore Semua Data</a>
        <form action="{{ route('post.delete-all-permanent') }}"
            onsubmit="return confirm('Apakah Anda Yakin Untuk Menghapus Semua Data Informasi Secara Permanen ?')"
            method="post" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger mb-3"><i class="fas fa-trash"></i> Hapus Semua Secara
                Permanen</button>
        </form>
        <a href="{{ route('post.index') }}" class="btn btn-primary mb-3"><i class="fas fa-angle-double-left"></i>
            Kembali</a>
    </div>
    @endcan
</div>
@include('components.flash-message')
<div class="card shadow card-body">
    <div class="table-responsive">
        <table class="table table-striped" id="table-trash-article">
            <thead>
                <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th>Thumbnail</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Di buat pada</th>
                    <th>Di hapus pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $post)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ asset($post->thumbnail) }}" height="70px" alt="thumbnail post">
                    </td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category->name }}</td>
                    <td>{{ $post->authors->name }}</td>
                    <td>{{date('d-m-Y', strtotime($post->created_at))}}</td>
                    <td>{{date('d-m-Y', strtotime($post->deleted_at))}}</td>
                    <td>
                        <a href="{{ route('post.restore', Crypt::encrypt($post->id)) }}" class="btn btn-info my-2"><i
                                class="far fa-folder-open" data-toggle="tooltip" data-placement="right"
                                title="Restore Data"
                                onclick="return confirm('Apakah Anda Yakin Untuk Me-Restore Data Informasi tersebut ?')"></i></a>
                        <form action="{{ route('post.delete-permanent', $post->id) }}"
                            onsubmit="return confirm('Apakah Anda Yakin Untuk Me-Hapus Data Informasi tersebut secara permanen ?')"
                            method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger my-2" data-toggle="tooltip"
                                data-placement="right" title="Hapus Data"
                                onsubmit="return confirm('Apakah Anda Yakin Untuk Me-Restore Data Informasi tersebut ?')"><i
                                    class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@include('components.data-table')
