<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Category::firstOrCreate(['nama_kategori' => 'Strategi Belajar'], ['deskripsi_kategori' => 'Diskusi tentang metode dan cara belajar yang efektif.']);
        Category::firstOrCreate(['nama_kategori' => 'Manajemen Stres'], ['deskripsi_kategori' => 'Berbagi cara mengatasi stres dan tekanan akademik.']);
        Category::firstOrCreate(['nama_kategori' => 'Tips Fokus & Produktivitas'], ['deskripsi_kategori' => 'Tingkatkan produktivitas dengan teknik fokus.']);
        Category::firstOrCreate(['nama_kategori' => 'Tanya Jawab Umum'], ['deskripsi_kategori' => 'Tempat bertanya apa saja seputar kehidupan perkuliahan.']);

        // --- TAMBAHKAN DATA BARU DI SINI ---
        Category::firstOrCreate(['nama_kategori' => 'Info Kampus'], ['deskripsi_kategori' => 'Berbagi informasi seputar kegiatan, beasiswa, dan pengumuman kampus.']);
        Category::firstOrCreate(['nama_kategori' => 'Off-Topic'], ['deskripsi_kategori' => 'Diskusi santai di luar topik akademik.']);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
