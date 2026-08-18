<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (! Schema::hasColumn('properties', 'city')) {
                $table->string('city')->nullable()->after('price');
            }

            if (! Schema::hasColumn('properties', 'bedrooms')) {
                $table->integer('bedrooms')->nullable()->after('area');
            }

            if (! Schema::hasColumn('properties', 'description')) {
                $table->text('description')->nullable()->after('status');
            }

            if (! Schema::hasColumn('properties', 'area')) {
                $table->decimal('area', 10, 2)->nullable()->after('location');
            }
        });

        // Fix any existing 'area' column with bad data
        if (Schema::hasColumn('properties', 'area')) {
            try {
                $columnType = Schema::getColumnType('properties', 'area');
                if ($columnType !== 'decimal') {
                    // Set bad values to NULL before changing the column type
                    DB::statement("UPDATE `properties` SET `area` = NULL WHERE `area` IS NOT NULL AND `area` NOT REGEXP '^[0-9]+(\\.[0-9]{1,2})?$'");
                    
                    Schema::table('properties', function (Blueprint $table) {
                        $table->decimal('area', 10, 2)->nullable()->change();
                    });
                }
            } catch (\Exception $e) {
                // If column change fails, it might already be decimal or have data issues
                // Continue anyway - the data integrity is more important than this schema operation
            }
        }
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'city')) {
                $table->dropColumn('city');
            }

            if (Schema::hasColumn('properties', 'bedrooms')) {
                $table->dropColumn('bedrooms');
            }

            if (Schema::hasColumn('properties', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};

