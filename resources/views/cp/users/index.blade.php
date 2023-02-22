@extends('layouts.app')
@section('title', 'Pengguna')

@push('styles')
    <style>
        .select2-container {
            width: 100% display: block !important
        }
    </style>
@endpush

@section('content')
    <div class="section-header">
        <h1>Pengguna</h1>
    </div>
    <div class="d-flex justify-content-between align-items-start mb-2">
        <h2 class="section-title m-0 mb-4">
            Data Pengguna
        </h2>
        @can('user-create')
            <button class="btn btn-primary" id="btn-create-user">Tambah Pengguna Baru</button>
        @endcan
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
                    @foreach ($data as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $role)
                                        <span class="badge badge-info">
                                            {{ $role }}
                                        </span>
                                        @can('users-edit')
                                            <button onclick="showDetailUser(`{{ $user->id }}`, `{{ $role }}`)"
                                                class="btn btn-primary btn-sm my-2 mx-2" data-toggle="tooltip"
                                                data-placement="right" title="Ganti role pengguna"><i
                                                    class="fas fa-cog"></i></button>
                                        @endcan
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @can('users-delete')
                                    <button type="submit" class="btn btn-danger my-2 mx-2"
                                        onclick="deleteUsers(`{{ $user->id }}`)"><i class="fas fa-trash"></i></a>
                                    @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="UserFormModal" tabindex="-1" aria-labelledby="UserFormModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="form-users">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userForm">User Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="hidden" id="id" name="id">
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                                name="name" autofocus="" value="{{ old('name') }}" />
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username"
                                class="form-control @error('username') is-invalid @enderror" name="username"
                                value="{{ old('username') }}" />
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" autofocus="" value="{{ old('email') }}" />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="roles" id="roles"
                                class="form-control select2 @error('roles') is-invalid @enderror" style="width:100%">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="UserFormModalEdit" tabindex="-1" aria-labelledby="UserFormModalEdit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="form-users-edit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userForm">Role User Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id_edited" id="id_edited">
                            <label for="role">Role</label>
                            <select name="roles" id="roles_edited"
                                class="form-control select2 @error('roles') is-invalid @enderror" style="width:100%">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@include('components.data-table')

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#btn-create-user').on('click', function() {
                $('#UserFormModal').modal('show')
            });

            $('#form-users').on('submit', function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let route = (id != '') ? `{{ url('cp/users/`+ id +`') }}` :
                    "{{ route('users.store') }}";
                console.log(id)
                let method = (id != '') ? 'put' : 'post';
                ajaxRequest($(this).serialize(), route, method)
                    .then(({
                        message
                    }) => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: message,
                            icon: 'success',
                        }).then(() => {
                            window.location.reload()
                        })
                    }).catch((e) => {
                        if (typeof(e.responseJSON.errors) == 'object') {
                            let textError = '';
                            $.each(e.responseJSON.errors, function(key, value) {
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
            })

            $('#form-users-edit').on('submit', function(e, id) {
                e.preventDefault()
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "untuk mengubah role pada user tersebut!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Ubah Sekarang!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let id = $('#id_edited').val();
                        let route = `{{ url('cp/users/` + id + `') }}`
                        let roles = $('#roles_edited').val();
                        console.log(roles)
                        ajaxRequest({
                                roles: $('#roles_edited').val()
                            }, route, 'PUT')
                            .then(({
                                message
                            }) => {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: message,
                                    icon: 'success',
                                }).then(() => {
                                    window.location.reload()
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
            });
        })

        const deleteUsers = (id) => {
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
                    let route = `{{ url('cp/users/` + id + `') }}`
                    ajaxRequest(null, route, 'DELETE')
                        .then(({
                            message
                        }) => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: message,
                                icon: 'success',
                            }).then(() => {
                                window.location.reload()
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

        const showDetailUser = (id, role) => {
            ajaxRequest(null, `{{ url('cp/users/` + id + `') }}`, 'GET')
                .then(({
                    data
                }) => {
                    $('#id_edited').val(data.id)
                    $('#roles_edited').val(role).trigger('change')
                    $('#UserFormModalEdit').modal('show')
                })
                .catch((e) => console.error(e))
        }
    </script>
@endpush
