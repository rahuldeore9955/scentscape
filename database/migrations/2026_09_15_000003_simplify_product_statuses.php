<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE products MODIFY status ENUM('active', 'inactive', 'draft', 'out_of_stock') NOT NULL DEFAULT 'active'");
        }

        DB::table('products')
            ->whereIn('status', ['draft', 'out_of_stock'])
            ->update(['status' => 'inactive']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE products MODIFY status ENUM('active', 'inactive') NOT NULL DEFAULT 'active'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE products MODIFY status ENUM('active', 'inactive', 'draft', 'out_of_stock') NOT NULL DEFAULT 'active'");
        }
    }
};
