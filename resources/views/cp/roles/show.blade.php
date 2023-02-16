@extends('layouts.main')
@section('title', 'Show Roles')
@section('content')
<div class="section-header">
    <h1>Detail Role</h1>
</div>
<div class="card shadow card-body">
    <strong>Nama :</strong>{{ $role->name }}
    <strong>permissions :</strong>{{ $role->name }}
    @if(!empty($rolePermissions))
    @foreach($rolePermissions as $items)
    <span>
        {{ $items->name }},
    </span>
    @endforeach
    @endif
    <div class="row">
        <div class="col-md-3 my-2">
            <a href="{{route('roles.index')}}" class="btn btn-danger">kembali</a>
        </div>
    </div>
</div>
@endsection
