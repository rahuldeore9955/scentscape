<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('products')->update(['sku' => null]);

        DB::table('products')->select('id')->orderBy('id')->each(function ($product) {
            DB::table('products')->where('id', $product->id)->update([
                'sku' => 'SC-'.str_pad((string) $product->id, 3, '0', STR_PAD_LEFT),
            ]);
        });
    }

    public function down(): void
    {
        // Product IDs remain stable if this migration is rolled back.
    }
};
