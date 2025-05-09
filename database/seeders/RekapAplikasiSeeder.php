<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class RekapAplikasiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            DB::table('rekap_aplikasi')->insert([
                'nama' => $faker->company,
                'subdomain' => $faker->domainName,
                'tipe' => $faker->randomElement(['web', 'apk']),
                'jenis' => $faker->randomElement(['pengembangan', 'baru']),
                'status' => $faker->randomElement(['diproses', 'perbaikan', 'assessment1', 'assessment2', 'development', 'prosesBA', 'selesai', 'batal']),
                'server' => $faker->ipv4,
                'keterangan' => $faker->sentence,
                'last_update' => $faker->sentence,
                'jenis_permohonan' => $faker->randomElement(['subdomain', 'permohonan']),
                'tanggal_masuk_ba' => $faker->date(),
                'link_dokumentasi' => $faker->url,

                'akun_link' => $faker->url,
                'akun_username' => $faker->userName,
                'akun_password' => $faker->password,

                'cp_opd_nama' => $faker->name,
                'cp_opd_no_telepon' => $faker->phoneNumber,

                'cp_pengembang_nama' => $faker->name,
                'cp_pengembang_no_telepon' => $faker->phoneNumber,

                'assesment_terakhir' => $faker->date(),
                'permohonan' => $faker->date(),
                'undangan_terakhir' => $faker->date(),
                'laporan_perbaikan' => $faker->date(),

                'status_server' => $faker->randomElement(['OPEN', 'CLOSE']),
                'open_akses' => $faker->date(),
                'close_akses' => $faker->date(),
                'urgensi' => $faker->randomElement(['tinggi', 'sedang', 'rendah']),

                'opd_id' => rand(1, 158),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
