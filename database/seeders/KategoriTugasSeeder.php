<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriTugas;

class KategoriTugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriTugas::create([
            'nama_kategori' => 'Tugas Harian',
            'bobot' => 20,
        ]);
        
        KategoriTugas::create([
            'nama_kategori' => 'Ulangan Harian',
            'bobot' => 30,
        ]);
        
        KategoriTugas::create([
            'nama_kategori' => 'UTS',
            'bobot' => 25,
        ]);
        
        KategoriTugas::create([
            'nama_kategori' => 'UAS',
            'bobot' => 25,
        ]);
    }
}
