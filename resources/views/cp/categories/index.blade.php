@extends('layouts.app')
@section('title', 'Kategori')
@section('content')
    <div class="section-header">
        <h1>Kategori</h1>
    </div>
    <div class="d-flex justify-content-between align-items-start mb-2">
        <h2 class="section-title m-0 mb-4">
            Data Kategori
        </h2>
        <button class="btn btn-primary" id="btn-create-category">Tambah</button>
    </div>
    <div class="card shadow card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table-category" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="CategoryFormModal" tabindex="-1" aria-labelledby="CategoryFormModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="form-category">
                    <div class="modal-header">
                        <h5 class="modal-title" id="CategoryForm">Kategori Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <label for="name">Nama</label>
                            <input type="text" id="name" class="form-control" name="name"
                                placeholder="Masukkan Nama Kategori">
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
            showCategories();

            $('#btn-create-category').on('click', function() {
                $('#CategoryFormModal').modal('show')
            });

            $('#form-category').on('submit', function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let route = (id != '') ? `{{ url('cp/content/categories/`+ id +`') }}` :
                    "{{ route('categories.store') }}";
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
                            resetForm();
                            showCategories()
                            $('#CategoryFormModal').modal('hide')
                        })
                    }).catch((e) => {
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
            })
        })

        const deleteCategory = (id) => {
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
                    ajaxRequest(null, `{{ url('cp/content/categories/` + id + `') }}`, 'delete')
                        .then(({
                            message
                        }) => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: message,
                                icon: 'success',
                            }).then(() => {
                                resetForm();
                                showCategories()
                                $('#CategoryFormModal').modal('hide')
                            })
                        })
                        .catch((e) => console.error(e))
                }
            })
        }

        const showDetailCategory = (id) => {
            ajaxRequest(null, `{{ url('cp/content/categories/` + id + `') }}`, 'GET')
                .then(({
                    data
                }) => {
                    $('#id').val(data.id)
                    $('#name').val(data.name)
                    $('#CategoryFormModal').modal('show')
                })
                .catch((e) => console.log(e))
        }

        const showCategories = () => {
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
            showDataTable('#table-category', "{{ route('category.datatable') }}", columns)
        }

        function resetForm() {
            $('#id').val('')
            $('#name').val('')
        }
    </script>
@endpush
