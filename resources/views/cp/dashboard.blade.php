@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="section-header">
    <h1>Dashboard</h1>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Pengguna</h4>
                </div>
                <div class="card-body">#</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Content Name</h4>
                </div>
                <div class="card-body">#</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="far fa-newspaper"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Post</h4>
                </div>
                <div class="card-body">#</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Content Name</h4>
                </div>
                <div class="card-body">#</div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-12 col-sm-12">
        <div class="card shadow">
            <div class="card-header">
                <h4>Aktifitas Pengguna</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table-activity">
                    <thead>
                        <tr>
                            <th class="text-center">
                                #
                            </th>
                            <th>Avatar</th>
                            <th>Nama Pengguna</th>
                            <th>Waktu</th>
                            <th>Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <img class="mr-3 rounded-circle" width="50" src="assets/img/avatar/avatar-1.png"
                                    alt="avatar" />
                            </td>
                            <td class="media-title">
                                <strong> {{ $activity->user->name }}</strong>
                            </td>
                            <td>
                                {{ $activity->created_at->diffForHumans() }}
                            </td>
                            <td>
                                {{ $activity->action }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="alert alert-danger">Belum Data Aktifitas Pengguna</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
@include('components.data-table')
