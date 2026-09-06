<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('addresses')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('count(*) > 1')
            ->orderBy('user_id')
            ->get()
            ->each(function ($row) {
                $keepId = DB::table('addresses')
                    ->where('user_id', $row->user_id)
                    ->orderByDesc('is_default')
                    ->orderByDesc('updated_at')
                    ->orderByDesc('id')
                    ->value('id');

                DB::table('addresses')
                    ->where('user_id', $row->user_id)
                    ->where('id', '!=', $keepId)
                    ->delete();

                DB::table('addresses')
                    ->where('id', $keepId)
                    ->update(['is_default' => true]);
            });

        if (!$this->hasUserAddressUniqueIndex()) {
            Schema::table('addresses', function (Blueprint $table) {
                $table->unique('user_id');
            });
        }
    }

    public function down(): void
    {
        if ($this->hasUserAddressUniqueIndex()) {
            Schema::table('addresses', function (Blueprint $table) {
                $table->dropUnique(['user_id']);
            });
        }
    }

    private function hasUserAddressUniqueIndex(): bool
    {
        return collect(DB::select("SHOW INDEX FROM addresses WHERE Column_name = 'user_id' AND Non_unique = 0"))
            ->isNotEmpty();
    }
};
