<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            if (Schema::hasColumn('properties', 'area') && Schema::getColumnType('properties', 'area') !== 'decimal') {
                $table->decimal('area', 10, 2)->nullable()->change();
            } elseif (! Schema::hasColumn('properties', 'area')) {
                $table->decimal('area', 10, 2)->nullable()->after('location');
            }
        });
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

            if (Schema::hasColumn('properties', 'area') && Schema::getColumnType('properties', 'area') === 'decimal') {
                $table->string('area')->nullable()->change();
            }
        });
    }
};
