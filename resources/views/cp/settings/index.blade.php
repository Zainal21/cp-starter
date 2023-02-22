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
                            <input type="text" id="name" name="setting[name]" class="form-control"
                                value="{{ isset($settings->name) ? $settings->name : '' }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="tagline" class="form-control-label col-sm-2 text-md-right">Tagline</label>
                        <div class="col-sm-6 col-md-6">
                            <input type="text" id="tagline" name="setting[tagline]" class="form-control"
                            value="{{ isset($settings->tagline) ? $settings->tagline : '' }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="site_description" class="form-control-label col-sm-2 text-md-right">Deskripsi
                            Website</label>
                        <div class="col-sm-6 col-md-6">
                            <textarea id="site_description" name="setting[description]" class="form-control" rows="3" style="height: auto;">
                                {{isset($settings->description) ? $settings->description : ''}}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="address" class="form-control-label col-sm-2 text-md-right">Alamat</label>
                        <div class="col-sm-6 col-md-6">
                            <textarea id="address" name="setting[address]" class="form-control" rows="3" style="height: auto;">
                                {{isset($settings->address) ? $settings->address : ''}}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="phone" class="form-control-label col-sm-2 text-md-right">Telepon</label>
                        <div class="col-sm-6 col-md-6">
                            <input type="text" id="phone" name="setting[phone]" class="form-control" value="{{isset($settings->phone) ? $settings->phone : ''}}">
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <div class="col-sm-6 col-md-6 offset-md-2">
                            <button class="btn btn-primary" id="save-btn">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        CKEDITOR.replace('about_description', config);
    </script>
@endpush
