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
                'brand'             => 'Chanel',
                'short_description' => 'An iconic floral aldehyde fragrance, a timeless masterpiece.',
                'price'             => 11250,
                'category'          => 'women',
                'badge'             => 'bestseller',
                'size'              => '100ml / 3.4 FL. OZ.',
                'sku'               => 'CHN-005-100',
            ],
            [
                'name'              => 'Sauvage Eau de Toilette',
                'brand'             => 'Dior',
                'short_description' => 'A radically fresh composition, dictated by a cold and noble mineral note.',
                'price'             => 10000,
                'category'          => 'men',
                'badge'             => 'new',
                'size'              => '100ml / 3.4 FL. OZ.',
                'sku'               => 'DIO-SAV-100',
            ],
            [
                'name'              => 'Black Opium Eau de Parfum',
                'brand'             => 'Yves Saint Laurent',
                'short_description' => 'The original shocking gourmand coffee fragrance.',
                'price'             => 8650,
                'original_price'    => 10813,
                'category'          => 'women',
                'badge'             => 'sale',
                'size'              => '100ml / 3.4 FL. OZ.',
                'sku'               => 'YSL-BOP-100',
            ],
            [
                'name'              => 'Oud Wood Eau de Parfum',
                'brand'             => 'Tom Ford',
                'short_description' => 'A rare and magical oud wood balanced with warm spices.',
                'price'             => 24500,
                'category'          => 'men',
                'size'              => '100ml / 3.4 FL. OZ.',
                'sku'               => 'TFO-OUD-100',
            ],
            [
                'name'              => 'Santal 33 Eau de Parfum',
                'brand'             => 'Le Labo',
                'short_description' => 'A rich sandalwood and cedarwood blend with a smoky finish.',
                'price'             => 20400,
                'category'          => 'unisex',
                'badge'             => 'bestseller',
                'size'              => '100ml / 3.4 FL. OZ.',
                'sku'               => 'LLB-S33-100',
            ],
            [
                'name'              => 'Bloom Eau de Parfum',
                'brand'             => 'Gucci',
                'short_description' => 'An opulent floral fragrance inspired by a rich garden.',
                'price'             => 10650,
                'category'          => 'women',
                'size'              => '100ml / 3.4 FL. OZ.',
                'sku'               => 'GUC-BLM-100',
            ],
            [
                'name'              => 'Bleu de Chanel Eau de Parfum',
                'brand'             => 'Chanel',
                'short_description' => 'A woody aromatic fragrance for men who defy convention.',
                'price'             => 12500,
                'category'          => 'men',
                'badge'             => 'new',
                'size'              => '100ml / 3.4 FL. OZ.',
                'sku'               => 'CHN-BDC-100',
            ],
            [
                'name'              => 'Gypsy Water Eau de Parfum',
                'brand'             => 'Byredo',
                'short_description' => 'A fresh pine and incense inspired by the gypsy nomad spirit.',
                'price'             => 18300,
                'category'          => 'unisex',
                'size'              => '100ml / 3.4 FL. OZ.',
                'sku'               => 'BYR-GYW-100',
            ],
        ];

        foreach ($products as $data) {
            $data['slug'] = Str::slug($data['name']);
            $data['description'] = $data['short_description'];
            $data['status'] = 'active';
            Product::firstOrCreate(['sku' => $data['sku']], $data);
        }
    }
}
