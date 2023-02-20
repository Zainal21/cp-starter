@extends('layouts.app')

@section('title', 'Perawatan Website')

@section('content')
<div class="section-header">
    <h1>Perawatan Website</h1>
</div>
<div class="d-flex justify-content-between align-items-start mb-2">
    <h2 class="section-title m-0 mb-4">
        Halaman Perawatan Website
    </h2>
</div>
<livewire:laravel_backup_panel::app />
@endsection
