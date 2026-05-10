<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->unique()->after('name');
            $table->string('barcode')->nullable()->unique()->after('sku');
            $table->decimal('cost_price', 10, 2)->default(0)->after('description');
            $table->integer('reorder_threshold')->default(5)->after('stock_quantity');
            $table->integer('sold_quantity')->default(0)->after('stock_quantity');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku', 'barcode', 'cost_price', 'reorder_threshold', 'sold_quantity']);
        });
    }
};
