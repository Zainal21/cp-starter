@extends('layouts.app')
@section('title', 'Tambah Informasi')
@section('content')
    <div class="section-header">
        <h1>Tambah Konten</h1>
    </div>
    <div class="section body">
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" id="form-create-post">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4 class="text-black-50">Konten</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" id="title"
                                    class="form-control @error('title') is-invalid @enderror" name="title" autofocus=""
                                    value="{{ old('title') }}" title />
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_id">Kategori</label>
                                <select name="category_id"
                                    class="form-control select2 @error('category_id') is-invalid @enderror" id="">
                                    <option disabled selected>pilih kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="content">Deskripsi</label>
                                <textarea id="content" cols="30" rows="10" class="summernote @error('content') is-invalid @enderror"
                                    style="height: auto" name="content">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4 class="text-black-50">Meta</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Thumbnail</label>
                                <div class="mb-2">
                                    <img src="" class="img-fluid" alt="" id="upload-img-preview"
                                        style="display: none;" />
                                    <a href="#" class="text-danger" id="upload-img-delete"
                                        style="display: none">Delete
                                        Thumbnail Image</a>
                                </div>
                                <div class="custom-file">
                                    <input type="file" accept="image/*" name="thumbnail" id="cover"
                                        class="custom-file-input js-upload-image form-control{{ $errors->has('thumbnail') ? ' is-invalid' : '' }}" />
                                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                                    @error('thumbnail')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        Simpan
                                    </button>
                                    <a href="{{ route('post.index') }}" class="btn btn-danger"
                                        onclick="return confirm('Apakah anda yakin untuk meninggalkan halaman ini ?')">Batal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#form-create-post').on('submit', function(e) {
                e.preventDefault()
                var formData = new FormData(this)
                ajaxRequestFormData(formData, $(this).attr('action'), "POST")
                    .then(({
                        message
                    }) => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: message,
                            icon: 'success',
                        }).then(() => {
                          window.location.href = "{{route('post.index')}}"
                        })
                    }).catch((e) => {
                        console.log(e)
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
    </script>
@endpush
