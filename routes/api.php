<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/master-aplikasi/{id}', function ($id) {
    $masterAplikasi = \App\Models\MasterRekapAplikasi::findOrFail($id);
    return response()->json([
        'tipe' => $masterAplikasi->tipe,
        'jenis_permohonan' => $masterAplikasi->jenis_permohonan,
        'subdomain' => $masterAplikasi->subdomain,
        'akun_link' => $masterAplikasi->akun_link,
        'akun_username' => $masterAplikasi->akun_username,
        'akun_password' => $masterAplikasi->akun_password,
    ]);
});