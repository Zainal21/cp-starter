@extends('layouts.app')
@section('title', 'Informasi')
@section('content')
    <div class="section-header">
        <h1>Informasi</h1>
    </div>
    <div class="d-flex justify-content-between align-items-start mb-2">
        <h2 class="section-title m-0 mb-4">
            Data Informasi
        </h2>
        <div class="float-right">
            <a href="{{ route('post.create') }}" class="btn btn-primary mb-3">Tambah</a>
            <a href="{{ route('post.trash') }}" class="btn btn-danger mb-3" data-toggle="tooltip" data-placement="right"
                title="Tempat Sampah"><i class="fas fa-trash"></i></a>
        </div>
    </div>
    <div class="card shadow card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table-posts">
                <thead>
                    <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Di buat pada</th>
                        <th>Aksi</th>
                        <th>publish / Archive</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@include('components.data-table')

@push('scripts')
    <script>
        $(document).ready(function() {
            showPosts()
        });

        const showPosts = () => {
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
                    data: 'authors_name',
                    name: 'authors_name'
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
                    data: 'action',
                    name: 'action'
                },
                {
                    data: 'utils',
                    name: 'utils'
                },
            ]
            showDataTable('#table-posts', "{{ route('posts.datatable') }}", columns)
        }

        const deletePost = (id) => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "untuk menghapus data tersebut!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let route = `{{ url('cp/content/post/` + id + `') }}`
                    ajaxRequest(null, route, 'DELETE')
                        .then(({
                            message
                        }) => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: message,
                                icon: 'success',
                            }).then(() => {
                                showPosts()
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


        const publishPost = (id) => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "untuk mempublish Postingan tersebut!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Publish Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let route = `{{ url('cp/content/post/` + id + `/publish') }}`
                    ajaxRequest(null, route, 'PUT')
                        .then(({
                            message
                        }) => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: message,
                                icon: 'success',
                            }).then(() => {
                                showPosts()
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

        const archivePost = (id) => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "untuk mengarsipkan Postingan tersebut!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Arsipkan Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let route = `{{ url('cp/content/post/` + id + `/archive') }}`
                    ajaxRequest(null, route, 'PUT')
                        .then(({
                            message
                        }) => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: message,
                                icon: 'success',
                            }).then(() => {
                                showPosts()
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

        const restorePost = (id) => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "untuk me-restore Postingan tersebut!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Publish Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let route = `{{ url('cp/content/post/utils/` + id + `/restore') }}`
                    ajaxRequest(null, route, 'PUT')
                        .then(({
                            message
                        }) => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: message,
                                icon: 'success',
                            }).then(() => {
                                showPosts()
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


        const deletePermanentPost = (id) => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "untuk mengapus Postingan tersebut secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Publish Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let route = `{{ url('cp/content/post/utils/` + id + `/delete-permanent') }}`
                    ajaxRequest(null, route, 'DELETE')
                        .then(({
                            message
                        }) => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: message,
                                icon: 'success',
                            }).then(() => {
                                showPosts()
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
    </script>
@endpush
