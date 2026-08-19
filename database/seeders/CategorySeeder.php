<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Batik Tulis',
                'description' => 'Dibuat dengan canting dan malam secara manual oleh pengrajin, setiap lembar memiliki keunikan tersendiri.',
                'sort_order' => 1,
                'products' => ['Batik Parang', 'Batik Sidoluhur', 'Batik Truntum', 'Batik Sekar Jagad', 'Batik Lasem', 'Batik Sido Asih'],
            ],
            [
                'name' => 'Batik Cap',
                'description' => 'Dicap dengan pola yang rapi dan konsisten, harga lebih terjangkau tanpa kehilangan keindahan motif.',
                'sort_order' => 2,
                'products' => ['Batik Kawung', 'Batik Ceplok', 'Batik Tambal', 'Batik Pring Sedapur'],
            ],
            [
                'name' => 'Batik Printing',
                'description' => 'Dicetak dengan teknologi modern sehingga menghasilkan warna cerah dan pola presisi dalam jumlah besar.',
                'sort_order' => 3,
                'products' => ['Batik Tujuh Rupa', 'Batik Jlamprang', 'Batik Gentongan'],
            ],
            [
                'name' => 'Kain & Pakaian',
                'description' => 'Batik siap pakai dalam bentuk kain maupun pakaian jadi, nyaman dipakai untuk segala kesempatan.',
                'sort_order' => 4,
                'products' => ['Batik Mega Mendung', 'Batik Cendrawasih'],
            ],
        ];

        $featured = ['Batik Parang', 'Batik Mega Mendung', 'Batik Lasem', 'Batik Gentongan'];

        foreach ($categories as $data) {
            $products = $data['products'];
            unset($data['products']);

            $category = Category::firstOrCreate(
                ['slug' => Str::slug($data['name'])],
                $data
            );

            foreach ($products as $name) {
                Product::where('name', $name)->update([
                    'category_id' => $category->id,
                    'is_featured' => in_array($name, $featured),
                ]);
            }
        }
    }
}
