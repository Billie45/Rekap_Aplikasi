@extends('layouts.app')

@section('content')
    {{-- <h1>Halaman Dashboard User</h1> --}}
    <div class="bg-white rounded shadow p-4 mt-4">
    @include('components.rekap-assessment-1', ['aplikasis' => $aplikasis])
    </div>
@endsection
