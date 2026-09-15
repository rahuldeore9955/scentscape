<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name'              => 'Chanel No. 5 Eau de Parfum',
                'short_description' => 'An iconic floral aldehyde fragrance, a timeless masterpiece.',
                'price'             => 11250,
                'category'          => 'women',
                'badge'             => 'bestseller',
                'size'              => '100ml / 3.4 FL. OZ.',
            ],
            [
                'name'              => 'Sauvage Eau de Toilette',
                'short_description' => 'A radically fresh composition, dictated by a cold and noble mineral note.',
                'price'             => 10000,
                'category'          => 'men',
                'badge'             => 'new',
                'size'              => '100ml / 3.4 FL. OZ.',
            ],
            [
                'name'              => 'Black Opium Eau de Parfum',
                'short_description' => 'The original shocking gourmand coffee fragrance.',
                'price'             => 8650,
                'category'          => 'women',
                'badge'             => 'sale',
                'size'              => '100ml / 3.4 FL. OZ.',
            ],
            [
                'name'              => 'Oud Wood Eau de Parfum',
                'short_description' => 'A rare and magical oud wood balanced with warm spices.',
                'price'             => 24500,
                'category'          => 'men',
                'size'              => '100ml / 3.4 FL. OZ.',
            ],
            [
                'name'              => 'Santal 33 Eau de Parfum',
                'short_description' => 'A rich sandalwood and cedarwood blend with a smoky finish.',
                'price'             => 20400,
                'category'          => 'unisex',
                'badge'             => 'bestseller',
                'size'              => '100ml / 3.4 FL. OZ.',
            ],
            [
                'name'              => 'Bloom Eau de Parfum',
                'short_description' => 'An opulent floral fragrance inspired by a rich garden.',
                'price'             => 10650,
                'category'          => 'women',
                'size'              => '100ml / 3.4 FL. OZ.',
            ],
            [
                'name'              => 'Bleu de Chanel Eau de Parfum',
                'short_description' => 'A woody aromatic fragrance for men who defy convention.',
                'price'             => 12500,
                'category'          => 'men',
                'badge'             => 'new',
                'size'              => '100ml / 3.4 FL. OZ.',
            ],
            [
                'name'              => 'Gypsy Water Eau de Parfum',
                'short_description' => 'A fresh pine and incense inspired by the gypsy nomad spirit.',
                'price'             => 18300,
                'category'          => 'unisex',
                'size'              => '100ml / 3.4 FL. OZ.',
            ],
        ];

        foreach ($products as $data) {
            $data['slug'] = Str::slug($data['name']);
            $data['description'] = $data['short_description'];
            $data['status'] = 'active';
            Product::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
