@extends('layouts.app')

@section('content')
@include('components.template-tabel')

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4">Manajemen Pengguna</h4>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" style="table-layout: fixed;">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Nama</th>
                            <th style="width: 25%">Email</th>
                            <th style="width: 20%">Role</th>
                            <th style="width: 20%">OPD</th>
                            <th style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $n = $users->firstItem();
                        @endphp
                        @foreach($users as $user)
                        <tr style="height: 50px;">
                            <td class="align-middle text-center">{{ $n++ }}</td>
                            <td class="align-middle text-truncate" title="{{ $user->name }}">{{ $user->name }}</td>
                            <td class="align-middle text-truncate" title="{{ $user->email }}">{{ $user->email }}</td>
                            <td class="align-middle p-1">
                                <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="form-control form-control-sm">
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="opd" {{ $user->role == 'opd' ? 'selected' : '' }}>OPD</option>
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                            </td>
                            <td class="align-middle p-1">
                                <select name="opd_id" class="form-control form-control-sm">
                                    <option value="">-- Pilih OPD --</option>
                                    @foreach($opds as $opd)
                                        <option value="{{ $opd->id }}" {{ $user->opd_id == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->nama_opd }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="align-middle p-1">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                                </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class ="mt-3">
    {{ $users->links('pagination::tailwind') }}
</div>
@endsection
