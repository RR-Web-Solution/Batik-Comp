<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'customer_name' => 'Ibu Ratna Sari',
                'customer_title' => 'Pecinta Batik',
                'content' => 'Kualitas batik dari Batik Nusantara luar biasa. Motifnya sangat detail dan warnanya tidak luntur setelah dicuci berkali-kali. Sangat puas dengan pembelian saya!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'customer_name' => 'Bapak Hendra Wijaya',
                'customer_title' => 'Kolektor Batik',
                'content' => 'Sudah menjadi pelanggan setia sejak 2019. Setiap karya yang saya terima selalu melebihi ekspektasi. Pengiriman juga selalu tepat waktu.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'customer_name' => 'Dewi Lestari',
                'customer_title' => 'Pengusaha Fashion',
                'content' => 'Batik Nusantara menjadi supplier utama untuk koleksi saya. Kerjasama yang profesional dan hasil yang konsisten. Terima kasih Batik Nusantara!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'customer_name' => 'Ahmad Rizky',
                'customer_title' => 'Wisatawan',
                'content' => 'Beli batik sebagai oleh-oleh untuk keluarga di Jepang. Mereka sangat terkesan dengan keindahan motif dan kualitas kainnya. Pasti akan beli lagi.',
                'rating' => 4,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'customer_name' => 'Siti Nurhaliza',
                'customer_title' => 'Desainer Interior',
                'content' => 'Penggunaan batik dalam proyek interior saya selalu mendapat pujian dari klien. Batik Nusantara menyediakan motif yang autentik dan berkualitas tinggi.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
