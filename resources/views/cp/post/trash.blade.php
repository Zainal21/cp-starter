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
        <div class="float-right d-inline">
            <button class="btn btn-info mb-3" onclick="restoreAllPost()"><i class="far fa-folder-open"></i> Restore Semua
                Data</button>
            <button type="button" onclick="deletePermanentAllPost()" class="btn btn-danger mb-3"><i class="fas fa-trash"></i>
                Hapus Semua Secara
                Permanen</button>
            <a href="{{ route('post.index') }}" class="btn btn-primary mb-3"><i class="fas fa-angle-double-left"></i>
                Kembali</a>
        </div>
    </div>
    @include('components.flash-message')
    <div class="card shadow card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table-trash-post">
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
                </tbody>
            </table>
        </div>
    </div>
@endsection

@include('components.data-table')

@push('scripts')
    <script>
        $(document).ready(function() {
            showPostInTrash()
        });

        const restoreAllPost = () => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "untuk memulihkan semua data postingan tersebut!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Pulihkan Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let route = `{{ route('post.restore-all') }}`
                    ajaxRequest(null, route, 'PUT')
                        .then(({
                            message
                        }) => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: message,
                                icon: 'success',
                            }).then(() => {
                                showPostInTrash()
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
        }

        const deletePermanentAllPost = () => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "untuk memulihkan semua data postingan tersebut!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let route = `{{ route('post.delete-all-permanent') }}`
                    ajaxRequest(null, route, 'DELETE')
                        .then(({
                            message
                        }) => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: message,
                                icon: 'success',
                            }).then(() => {
                                showPostInTrash()
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
        }

        const showPostInTrash = () => {
            const columns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    data: 'thumnail_image',
                    name: 'thumnail_image',
                    render: function(data, type, full, meta) {
                        let asset = "{{ url('/') }}/"
                        return `<img src="${asset+data}" height="50"/>`;
                    }
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'status_posts',
                    name: 'status_posts'
                },
                {
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'deleted_at',
                    name: 'deleted_at'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
            showDataTable('#table-trash-post', "{{ route('posts-in-trash.datatable') }}", columns)
        }
    </script>
@endpush
