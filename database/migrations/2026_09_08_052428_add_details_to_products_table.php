<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('code')->nullable()->unique()->after('id');
            $table->string('category')->nullable()->after('name');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->string('unit')->nullable();
            $table->string('image')->nullable();
            $table->boolean('vat_enabled')->default(false);
            $table->unsignedTinyInteger('vat_percentage')->nullable()->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('brand_id');
            $table->dropColumn(['code', 'category', 'unit', 'image', 'vat_enabled', 'vat_percentage']);
        });
    }
};
