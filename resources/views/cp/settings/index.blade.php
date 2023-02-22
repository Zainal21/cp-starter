@extends('layouts.app')

@section('title', 'Pengaturan Website')

@section('content')
    <div class="section-header">
        <h1>Pengaturan Website</h1>
    </div>
    <div class="card shadow card-body">
        <div class="row">
            <div class="col-12">
                <form id="setting-form" action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row align-items-center">
                        <label for="name" class="form-control-label col-sm-2 text-md-right">Nama Website</label>
                        <div class="col-sm-6 col-md-6">
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ isset($settings->name) ? $settings->name : '' }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="tagline" class="form-control-label col-sm-2 text-md-right">Tagline</label>
                        <div class="col-sm-6 col-md-6">
                            <input type="text" id="tagline" name="tagline" class="form-control"
                            value="{{ isset($settings->tagline) ? $settings->tagline : '' }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="site_description" class="form-control-label col-sm-2 text-md-right">Deskripsi
                            Website</label>
                        <div class="col-sm-6 col-md-6">
                            <textarea id="site_description" name="description" class="form-control" rows="3" style="height: auto;">
                                {{isset($settings->description) ? $settings->description : ''}}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="address" class="form-control-label col-sm-2 text-md-right">Alamat</label>
                        <div class="col-sm-6 col-md-6">
                            <textarea id="address" name="address" class="form-control" rows="3" style="height: auto;">
                                {{isset($settings->address) ? $settings->address : ''}}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="code_analytic_google" class="form-control-label col-sm-2 text-md-right">Kode Analisis Google</label>
                        <div class="col-sm-6 col-md-6">
                            <textarea id="code_analytic_google"  name="code_analytic_google" class="form-control" rows="3" style="height: auto;">
                                {{isset($settings->code_analytic_google) ? $settings->code_analytic_google : ''}}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="phone" class="form-control-label col-sm-2 text-md-right">Telepon</label>
                        <div class="col-sm-6 col-md-6">
                            <input type="text" id="phone" name="phone" class="form-control" value="{{isset($settings->phone) ? $settings->phone : ''}}">
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <div class="col-sm-6 col-md-6 offset-md-2">
                            <button class="btn btn-primary" id="save-btn" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#setting-form').on('submit', function(e){
            e.preventDefault()
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "untuk mengubah data tersebut!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ubah Sekarang!'
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxRequest($(this).serialize(), $(this).attr('action'), 'PUT')
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
        })
    </script>
@endpush
