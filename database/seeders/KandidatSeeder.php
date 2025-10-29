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
                'foto' => 'foto-kandidat/calon-1.png',
                'visi' => 'Mewujudkan Pemira yang transparan dan akuntabel.',
                'misi' => '1. Meningkatkan partisipasi mahasiswa dalam Pemira. 2. Menyediakan informasi yang jelas dan akurat mengenai calon kandidat. 3. Meningkatkan kualitas debat kandidat.',
            ],
            [
                'id_kegiatan' => 1,
                'no_urut' => '02',
                'foto' => 'foto-kandidat/calon-2.png',
                'visi' => 'Mewujudkan DPM sebagai pilar legislasi yang adaptif dan kolaboraif, demi terciptanya tatanan emahasiswaan yang harmonis.',
                'misi' => '1. Menguatkan pelaksanaan tugas legislatif DPM secara bertanggung jawab dan selaras dengan aspirasi mahasiswa, berpedoman pada AD-ART dan GBHK. 2. Meningkatkan mutu pengawasan yang objektif dan solutif terhadap kinerja seluruh lembaga kemahasiswaan di lingkungan Fakultas Matematika dan Ilmu Pengetahuan Alam dan Ilmu Pengetahuan Alam. 3. Membangun sinergi dan kemitraan yang harmonis antar lembaga kemahasiswaan internal dan eksternal fakultas MIPA. 4. Menciptakan budaya kerja internal DPM yang solid, adaptif, dan saling mendukung guna mengoptimalkan kinerja kelembagaan',
            ]
        ]);

        // Proses setiap kandidat yang telah dibuat
        $nimCalon = ['2408551063', '2408561090'];
        Kandidat::all()->each(function ($kandidat, $i) use ($nimCalon) {
            // Ambil kegiatan dari kandidat yang dibuat
            // $id_kegiatan = $kandidat->id_kegiatan;
            // $kegiatan = Kegiatan::find($id_kegiatan);

            // Ambil 1 mahasiswa secara acak dengan program studi yang sama sebagai calon ketua
            // $mahasiswa = User::whereNotIn('nim', function ($query) {
            //         $query->select('nim')
            //             ->from('mahasiswa_kandidat');
            //     })
            //     ->get()
            //     ->random(1)
            //     ->first();
            $mahasiswa = User::find($nimCalon[$i]);
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
