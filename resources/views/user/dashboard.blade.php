@extends('layouts.app')

@section('content')
    {{-- <h1>Halaman Dashboard User</h1> --}}

    @include('components.rekap-assessment-1', ['aplikasis' => $aplikasis])

@endsection
