<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (! Schema::hasColumn('projects', 'type')) {
                $table->string('type')->nullable()->after('name');
            }

            if (! Schema::hasColumn('projects', 'city')) {
                $table->string('city')->nullable()->after('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'type')) {
                $table->dropColumn('type');
            }

            if (Schema::hasColumn('projects', 'city')) {
                $table->dropColumn('city');
            }
        });
    }
};
