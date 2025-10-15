<?php

namespace Database\Seeders;

use App\Models\Kandidat;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KandidatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kandidat::factory()->createMany([
            [
                'id_kegiatan' => 1,
                'no_urut' => '01',
                'foto' => 'foto-kandidat/fotopaslonbem1.png',
                'visi' => 'Mewujudkan Pemira yang transparan dan akuntabel.',
                'misi' => '1. Meningkatkan partisipasi mahasiswa dalam Pemira. 2. Menyediakan informasi yang jelas dan akurat mengenai calon kandidat. 3. Meningkatkan kualitas debat kandidat.',
            ],
            [
                'id_kegiatan' => 1,
                'no_urut' => '02',
                'foto' => 'foto-kandidat/fotopaslonbem2.png',
                'visi' => 'Mewujudkan Pemira yang transparan dan akuntabel.',
                'misi' => '1. Meningkatkan partisipasi mahasiswa dalam Pemira. 2. Menyediakan informasi yang jelas dan akurat mengenai calon kandidat. 3. Meningkatkan kualitas debat kandidat.',
            ]
        ]);

        // Proses setiap kandidat yang telah dibuat
        Kandidat::all()->each(function ($kandidat) {
            // Ambil kegiatan dari kandidat yang dibuat
            // $id_kegiatan = $kandidat->id_kegiatan;
            // $kegiatan = Kegiatan::find($id_kegiatan);

            // Ambil 1 mahasiswa secara acak dengan program studi yang sama sebagai calon ketua
            $mahasiswa = User::whereNotIn('nim', function ($query) {
                    $query->select('nim')
                        ->from('mahasiswa_kandidat');
                })
                ->get()
                ->random(1)
                ->first();
            if ($mahasiswa) {
                $kandidat->mahasiswa()->attach($mahasiswa->nim, [
                    'jabatan' => 'ketua',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
