@extends('layouts.main')
@section('title', 'Backup Database')
@section('content')
<div class="section-header">
    <h1>Backup Database</h1>
  </div>
<livewire:laravel_backup_panel::app />
@endsection    