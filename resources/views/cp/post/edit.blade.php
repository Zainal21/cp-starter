@extends('layouts.app')
@section('title', 'Edit Informasi')
@section('content')
    <div class="section-header">
        <h1>Edit Artikel</h1>
    </div>
    <div class="section body">
        <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="form-update-post">
            @csrf
            @method('PUT')
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
                                    value="{{ $post->title }}" />
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_id">Kategori</label>
                                <select name="category_id" class="form-control select2 @error('category_id') is-invalid @enderror"
                                    id="">
                                    @foreach ($categories as $category)
                                        <option {{ $category->id == $post->category_id ? ' selected' : '' }}
                                            value="{{ $category->id }}">{{ $category->name }}</option>
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
                                    style="height: auto" name="content">{{ $post->content }}</textarea>
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
                                    <img src="{{ asset($post->thumbnail) }}" class="img-fluid" alt="" id="img"
                                        style="width: 200px" />
                                    <p class="my-2 text-muted">Gambar Sebelumnya</p>
                                    <img src="" class="img-fluid" alt="" id="upload-img-preview"
                                        style="display: none;" />
                                    <a href="#" class="text-danger" id="upload-img-delete"
                                        style="display: none">Delete
                                        Cover Image</a>
                                </div>
                                <div class="custom-file">
                                    <input type="file" accept="image/*" name="thumbnail" id="cover"
                                        class="custom-file-input  js-upload-image form-control{{ $errors->has('thumbnail') ? ' is-invalid' : '' }}" />
                                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                                    @error('thumbnail')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary  my-2 ">
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
            $('#form-update-post').on('submit', function(e) {
                e.preventDefault()
                var formData = new FormData(this)
                ajaxRequestFormData(formData, $(this).attr('action'), "PUT")
                    .then(({
                        message
                    }) => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: message,
                            icon: 'success',
                        }).then(() => {
                            window.location.href = "{{ route('post.index') }}"
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
        })
    </script>
    @include('components.image-preview')
@endpush
