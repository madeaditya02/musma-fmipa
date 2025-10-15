<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kegiatan::factory()->createMany([
            [
                'nama' => 'Pemilihan Caka DPM FMIPA 2025',
                'tahun' => 2025,
                'waktu_mulai' => '2025-11-12 06:00:00',
                'waktu_selesai' => '2025-11-12 18:00:00',
                'ruang_lingkup' => 'fakultas',
                'id_program_studi' => null,
            ]
        ]);
    }
}
