@extends('layouts.app')



@section('content')
@include('components.template-form')
    <div class="container">

        @if (session('success'))
            <div>{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div style="color: red;">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('user.pengajuan.submit') }}">
            @csrf
            <label for="opd_id">Pilih OPD:</label>
            <select name="opd_id" required>
                @foreach($opds as $opd)
                    <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                @endforeach
            </select>
            <br><br>
            <button type="submit">Ajukan</button>
        </form>
    </div>
@endsection
