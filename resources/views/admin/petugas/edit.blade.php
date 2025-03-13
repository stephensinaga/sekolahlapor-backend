@extends('layouts.app')

@section('contents')
<div class="container">
    <h2>Edit Petugas</h2>
    <form action="{{ route('admin.petugas.update', $petugas->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" name="name" value="{{ $petugas->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $petugas->email }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password (Opsional)</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
