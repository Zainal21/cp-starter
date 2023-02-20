@extends('layouts.app')

@section('title', 'Slider')

@section('content')
    <div class="section-header">
        <h1>Slider</h1>
    </div>
    <div class="d-flex justify-content-between align-items-start mb-2">
        <h2 class="section-title m-0 mb-4">
            Data Slider
        </h2>
        <button class="btn btn-primary" id="btn-create-slider">Tambah</button>
    </div>
    <div class="card shadow card-body">
        <div class="table-responsive">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-sliders">
                    <thead>
                        <tr>
                            <th class="table-fit">#</th>
                            <th colspan="2" class="text-center">Order</th>
                            <th style="width: 175px;">Image</th>
                            <th>Caption</th>
                            <th class="table-fit">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sliders as $slider)
                            <tr>
                                <td class="table-fit">{{ $loop->iteration }}</td>
                                <td class="table-fit px-1">
                                    @if (!$loop->first)
                                        <button type="button" id="{{ $slider->id }}" data-type="up"
                                            class="btn btn-sm btn-light move">
                                            Move up <i class="fa fa-arrow-circle-up"></i>
                                        </button>
                                    @endif
                                </td>
                                <td class="table-fit px-1">
                                    @if (!$loop->last)
                                        <button type="button" id="{{ $slider->id }}" data-type="down"
                                            class="btn btn-sm btn-light move">
                                            Move down <i class="fa fa-arrow-circle-down"></i>
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <img src="{{ asset($slider->image) }}" class="img-fluid my-2">
                                </td>
                                <td>{{ $slider->caption }}</td>
                                <td class="table-fit">
                                    <button onClick="showDetailSlider({{ $slider->id }})"
                                        class="btn btn-primary btn-sm text-white mx-2">Edit</button>
                                    <button onClick="deleteSlider({{ $slider->id }})"
                                        class="btn btn-danger btn-sm text-white mx-2">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="sliderFormModal" tabindex="-1" aria-labelledby="sliderFormModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('sliders.store') }}" method="post" id="form-sliders">
                    <div class="modal-header">
                        <h5 class="modal-title" id="SliderForm">Slider Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <label for="caption" class="col-form-label text-right">Caption</label>
                            <textarea id="caption" cols="30" rows="5"
                                class="form-control{{ $errors->has('caption') ? ' is-invalid' : '' }}" style="height: auto;" name="caption">{{ old('caption') }}</textarea>
                        </div>
                        <div class="form-group">
                            <div class="image-previous-container collapse">
                                <img src="#" class="img-fluid" alt="" id="img-previous"
                                    style="width: 200px" />
                                <p class="my-2 text-muted">Gambar Sebelumnya</p>
                            </div>
                            <label for="image" class="text-right">Image</label>
                            <div class="mb-2">
                                <img src="" class="img-fluid" alt="" id="upload-img-preview"
                                    style="display: none;">
                                <a href="#" class="text-danger" id="upload-img-delete" style="display: none;">Delete
                                    Cover Image</a>
                            </div>
                            <div class="custom-file">
                                <input type="file" accept="image/*" name="image" id="image"
                                    class="custom-file-input js-upload-image form-control{{ $errors->has('image') ? ' is-invalid' : '' }}">
                                <label class="custom-file-label " for="image">Choose file</label>
                            </div>
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
            $('#btn-create-slider').on('click', function() {
                clearForm();
                $('.image-previous-container').addClass('collapse')
                $('#sliderFormModal').modal('show')
            });

            $('#form-sliders').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this)
                let id = $('#id').val();
                console.log(id)
                let route = id !== '' ? `{{ url('cp/content/sliders/`+id+`') }}` : $(this).attr('action')
                let formAdded = id !== '' ? formData.append('_method', 'PUT') : null;
                ajaxRequestFormData(formData, route, "POST")
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


        const deleteSlider = (id) => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "untuk mengapus Slider tersebut!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let route = `{{ url('cp/content/sliders/` + id + `') }}`
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

        const showDetailSlider = (id) => {
            clearForm()
            ajaxRequest(null, `{{ url('cp/content/sliders/` + id + `') }}`, 'GET')
                .then(({
                    data
                }) => {
                    $('.image-previous-container').removeClass('collapse')
                    let asset = "{{ url('/') }}"
                    $('#id').val(data.id)
                    $('#name').val(data.name)
                    $('#caption').val(data.caption)
                    $('#img-previous').attr('src', `${asset}/${data.image}`)
                    $('#sliderFormModal').modal('show')
                })
                .catch((e) => console.error(e))
        }

        $(".js-upload-image").change(function(event) {
            makePreview(this);
            $("#upload-img-preview").show();
            $("#upload-img-delete").show();
        });

        function makePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#upload-img-preview").attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#upload-img-delete").click(function(event) {
            event.preventDefault();
            $("#upload-img-preview").attr("src", "").hide();
            $(".custom-file-input").val(null);
            $(this).hide();
        });


        $('.move').click(function(event) {
            ajaxRequest({
                    type: $(this).attr('data-type'),
                    id: $(this).attr('id')
                }, "{{ route('sliders.move') }}", 'POST')
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
        });

        function clearForm(){
            $('#id').val('')
            $('#caption').val('')
            $('#form-sliders')[0].reset()
        }
    </script>
@endpush
