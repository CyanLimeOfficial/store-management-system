<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products_inventory', function (Blueprint $table) {
            $table->id('id_product');
            $table->foreignId('store_id')->constrained('store_info')->unique()->onDelete('cascade');
            $table->string('product_name')->unique();
            $table->float('price');
            $table->integer('quantity')->default('0');
            $table->string('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_inventory');
    }
};
