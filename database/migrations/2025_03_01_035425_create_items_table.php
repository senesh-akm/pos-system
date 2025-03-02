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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_image')->nullable();
            $table->string('refnumber');
            $table->string('product_code')->unique();
            $table->string('item_code')->unique();
            $table->string('item_name');
            $table->string('category');
            $table->string('barcode')->unique();
            $table->decimal('price', 10, 2);
            $table->enum('stock', ['In Stock', 'Out of Stock']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
