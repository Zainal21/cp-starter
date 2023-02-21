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
            </tbody>
        </table>
    </div>
</div>
@endsection

@include('components.data-table ')

@push('scripts')
    <script>
        $(document).ready(function(){
            showRoleAndPermission();
        });

        const showRoleAndPermission = () => {
            const columns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    data: 'name',
                    name: 'name'
                },

                {
                    data: 'action',
                    name: 'action'
                },
            ]
            showDataTable('#table-role', "{{ route('role.datatable') }}", columns)
        }


        const deleteRole = (id) => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "untuk menghapus data tersebut!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Sekarang!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let route = `{{ url('cp/roles/` + id + `') }}`
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
    </script>
@endpush