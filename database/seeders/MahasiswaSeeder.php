<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mahasiswa::create ([
            'Nim' => 1,
            'Nama' => 'Lee do hyun',
            'kelas_id' => 3,
            'Jurusan' => 'Teknik Mesin',
        ]);
        Mahasiswa::create ([
            'Nim' => 2,
            'Nama' => 'Haechan',
            'kelas_id' => 2,
            'Jurusan' => 'Teknik Mesin',
        ]);
    }
}
