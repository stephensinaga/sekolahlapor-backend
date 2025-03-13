@extends('layouts.app')

@section('contents')
<h2>Tugaskan Laporan</h2>
<form action="{{ route('admin.reports.assign', $report->id) }}" method="POST">
    @csrf
    <label>Pilih Petugas:</label>
    <select name="officer_id" class="form-control">
        @foreach ($officers as $officer)
        <option value="{{ $officer->id }}">{{ $officer->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary mt-2">Tugaskan</button>
</form>
@endsection

