<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Batik Parang',
                'description' => 'Motif parang klasik dengan corak diagonal yang tegas, melambangkan keberanian.',
                'price' => 350000,
            ],
            [
                'name' => 'Batik Mega Mendung',
                'description' => 'Motif awan khas Cirebon dengan gradasi biru lembut, melambangkan kesabaran.',
                'price' => 425000,
            ],
            [
                'name' => 'Batik Kawung',
                'description' => 'Motif geometris khas keraton yang elegan dan sarat makna kesucian.',
                'price' => 380000,
            ],
            [
                'name' => 'Batik Sidoluhur',
                'description' => 'Motif kemakmuran dari Solo dengan sentuhan pewarnaan alami.',
                'price' => 450000,
            ],
            [
                'name' => 'Batik Truntum',
                'description' => 'Motif cinta kasih yang lembut, populer untuk momen pernikahan.',
                'price' => 520000,
            ],
            [
                'name' => 'Batik Sekar Jagad',
                'description' => 'Motif keindahan dunia dengan pola bunga yang memukau dan berwarna-warni.',
                'price' => 480000,
            ],
            [
                'name' => 'Batik Lasem',
                'description' => 'Batik pesisir khas Rembang dengan warna merah menyala dan detail halus.',
                'price' => 560000,
            ],
            [
                'name' => 'Batik Pring Sedapur',
                'description' => 'Motif bambu yang anggun dari Magetan, melambangkan kesederhanaan.',
                'price' => 390000,
            ],
            [
                'name' => 'Batik Ceplok',
                'description' => 'Motif berpola kotak-kotak geometris yang rapi dan berkelas.',
                'price' => 370000,
            ],
            [
                'name' => 'Batik Tujuh Rupa',
                'description' => 'Motif khas Pekalongan dengan warna cerah dan nuansa alam.',
                'price' => 490000,
            ],
            [
                'name' => 'Batik Sido Asih',
                'description' => 'Motif kasih sayang yang penuh doa, cocok untuk hadiah istimewa.',
                'price' => 430000,
            ],
            [
                'name' => 'Batik Gentongan',
                'description' => 'Batik Madura dengan pewarnaan ganda yang menghasilkan warna dalam dan tahan lama.',
                'price' => 610000,
            ],
            [
                'name' => 'Batik Jlamprang',
                'description' => 'Motif geometris segi empat khas Pekalongan yang dipengaruhi budaya Timur Tengah.',
                'price' => 415000,
            ],
            [
                'name' => 'Batik Tambal',
                'description' => 'Motif penambal yang dipercaya membawa rezeki dan kesehatan bagi pemakainya.',
                'price' => 345000,
            ],
            [
                'name' => 'Batik Cendrawasih',
                'description' => 'Motif burung surga dari Papua yang eksotis dengan warna-warni alam.',
                'price' => 575000,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['name' => $product['name']], $product);
        }
    }
}
