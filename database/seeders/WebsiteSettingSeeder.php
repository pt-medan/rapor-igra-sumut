<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Branding Section
            [
                'key' => 'app_name',
                'value' => 'E-Rapor IGRA SUMUT',
                'type' => 'text',
                'label' => 'Application Name',
                'description' => 'Nama aplikasi yang ditampilkan di header dan title'
            ],
            [
                'key' => 'app_subtitle',
                'value' => 'Pendidikan Anak Usia Dini',
                'type' => 'text',
                'label' => 'Application Subtitle',
                'description' => 'Subtitle aplikasi di bawah nama di header'
            ],
            [
                'key' => 'app_logo',
                'value' => null,
                'type' => 'image',
                'label' => 'Application Logo',
                'description' => 'Logo aplikasi yang ditampilkan di header dan footer'
            ],
            [
                'key' => 'app_favicon',
                'value' => null,
                'type' => 'image',
                'label' => 'Application Favicon',
                'description' => 'Favicon (icon browser tab) untuk aplikasi'
            ],
            // Hero Section
            [
                'key' => 'hero_title',
                'value' => 'Sistem Rapor Digital untuk Raudhatul Athfal',
                'type' => 'text',
                'label' => 'Hero Title',
                'description' => 'Judul utama di bagian hero section halaman welcome'
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Kelola perkembangan siswa dengan kurikulum berbasis cinta yang komprehensif dan mudah digunakan',
                'type' => 'textarea',
                'label' => 'Hero Subtitle',
                'description' => 'Subtitle/deskripsi di bagian hero section'
            ],
            [
                'key' => 'hero_image',
                'value' => null,
                'type' => 'image',
                'label' => 'Hero Image',
                'description' => 'Gambar yang ditampilkan di hero section'
            ],
            // Features Section
            [
                'key' => 'features_title',
                'value' => 'Fitur Unggulan',
                'type' => 'text',
                'label' => 'Features Section Title',
                'description' => 'Judul section fitur'
            ],
            [
                'key' => 'features_subtitle',
                'value' => 'Semua yang Anda butuhkan untuk mengelola rapor siswa',
                'type' => 'textarea',
                'label' => 'Features Section Subtitle',
                'description' => 'Deskripsi singkat fitur'
            ],
            // Benefits Section
            [
                'key' => 'benefits_title',
                'value' => 'Mengapa Memilih E-Rapor IGRA?',
                'type' => 'text',
                'label' => 'Benefits Section Title',
                'description' => 'Judul section manfaat'
            ],
            // About Section
            [
                'key' => 'about_title',
                'value' => 'Tentang IGRA Sumut',
                'type' => 'text',
                'label' => 'About Section Title',
                'description' => 'Judul section tentang IGRA'
            ],
            [
                'key' => 'about_description',
                'value' => 'Ikatan Guru Raudhatul Athfal (IGRA) Sumut adalah organisasi profesi guru yang berdedikasi meningkatkan kualitas pendidikan anak usia dini di Sumatera Utara.',
                'type' => 'textarea',
                'label' => 'About Description',
                'description' => 'Deskripsi tentang IGRA Sumut'
            ],
            [
                'key' => 'about_vision',
                'value' => 'Kami berkomitmen untuk memberikan solusi inovatif dalam pendidikan berbasis cinta (Kurikulum Berbasis Cinta) yang mengintegrasikan nilai-nilai spiritual, akademik, dan karakter dalam proses pembelajaran anak.',
                'type' => 'textarea',
                'label' => 'About Vision',
                'description' => 'Visi dan misi IGRA Sumut'
            ],
            // CTA Section
            [
                'key' => 'cta_title',
                'value' => 'Siap Memulai?',
                'type' => 'text',
                'label' => 'CTA Title',
                'description' => 'Judul Call-to-Action section'
            ],
            [
                'key' => 'cta_description',
                'value' => 'Daftar sekarang dan mulai kelola rapor siswa Anda dengan lebih efisien',
                'type' => 'textarea',
                'label' => 'CTA Description',
                'description' => 'Deskripsi CTA section'
            ],
            // Footer
            [
                'key' => 'footer_about',
                'value' => 'Sistem rapor digital untuk Raudhatul Athfal berbasis kurikulum cinta',
                'type' => 'textarea',
                'label' => 'Footer About Text',
                'description' => 'Teks tentang aplikasi di footer'
            ],
            [
                'key' => 'footer_email',
                'value' => 'info@igra-sumut.org',
                'type' => 'text',
                'label' => 'Contact Email',
                'description' => 'Email untuk kontak di footer'
            ],
            [
                'key' => 'footer_phone',
                'value' => '+62 XXX XXXX XXXX',
                'type' => 'text',
                'label' => 'Contact Phone',
                'description' => 'Nomor telepon kontak di footer'
            ],
            [
                'key' => 'footer_copyright',
                'value' => '© 2025 E-Rapor IGRA Sumut. Semua hak dilindungi.',
                'type' => 'text',
                'label' => 'Copyright Text',
                'description' => 'Teks copyright di footer'
            ],
        ];

        foreach ($settings as $setting) {
            WebsiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}

