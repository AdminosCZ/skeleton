<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password');
        });

        // First existing user (if any) is promoted to admin — convention
        // used by Ghost, Discourse, etc. The seed admin created during
        // scaffold via `php artisan make:filament-user` thus keeps access
        // to admin-gated features after this migration runs.
        DB::table('users')
            ->whereRaw('id = (SELECT MIN(id) FROM users)')
            ->update(['role' => 'admin']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
