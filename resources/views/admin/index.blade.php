@extends('layouts.app')

@section('contents')
<h2>Daftar Laporan</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
        <tr>
            <td>{{ $report->id }}</td>
            <td>{{ $report->category }}</td>
            <td>{{ $report->description }}</td>
            <td>{{ ucfirst($report->status) }}</td>
            <td>
                <!-- Tombol Terima -->
                <button type="button" class="btn btn-success btn-sm open-modal" data-bs-toggle="modal" data-bs-target="#assignModal-{{ $report->id }}">
                    Terima
                </button>

                <!-- Tombol Tolak -->
                <form action="{{ route('admin.reports.verify', $report->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modals -->
@foreach ($reports as $report)
<div class="modal fade" id="assignModal-{{ $report->id }}" tabindex="-1" aria-labelledby="assignModalLabel-{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tugaskan Laporan #{{ $report->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.reports.assign', $report->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="accepted"> <!-- Pastikan laporan diterima -->

                <div class="modal-body">
                    <label>Pilih Petugas:</label>
                    <select name="officer_ids[]" class="form-control" multiple required>
                        @foreach ($officers as $officer)
                        <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Gunakan <kbd>Ctrl</kbd> (Windows) atau <kbd>Cmd</kbd> (Mac) untuk memilih lebih dari satu.</small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tugaskan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


@endsection
