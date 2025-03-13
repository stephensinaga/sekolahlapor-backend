@extends('layouts.app')

@section('contents')
<div class="container">
    <h2>Daftar Petugas</h2>
    <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary mb-3">Tambah Petugas</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($petugas as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->email }}</td>
                <td>
                    <a href="{{ route('admin.petugas.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.petugas.destroy', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus petugas ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
