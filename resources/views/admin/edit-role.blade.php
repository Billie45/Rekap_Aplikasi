@extends('layouts.app')

@section('content')
@include('components.template-tabel')

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4">Manajemen Pengguna</h4>

<div>
    <div>
        <div>
            <div>
                <table class="compact-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Username</th>
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
                            <td>{{ $n++ }}</td>
                            <td title="{{ $user->name }}">{{ $user->name }}</td>
                            <td title="{{ $user->email }}">{{ $user->email }}</td>
                            <td>
                                <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="form-control form-control-sm">
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="opd" {{ $user->role == 'opd' ? 'selected' : '' }}>OPD</option>
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                            </td>
                            <td>
                                <select name="opd_id" class="form-control form-control-sm select2">
                                    <option value="">-- Pilih OPD --</option>
                                    @foreach($opds as $opd)
                                        <option value="{{ $opd->id }}" {{ $user->opd_id == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->nama_opd }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-sm btn-success" title="Update" style="padding: 4px 8px;">
                                        <i class="bx bx-refresh" style="font-size: 1.2rem;"></i>
                                    </button>
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

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').each(function() {
            if (!$(this).hasClass('select2-hidden-accessible')) {
                $(this).select2({
                    placeholder: '-- Pilih OPD --',
                    allowClear: true
                });
            }
        });
    });
</script>
@endpush
