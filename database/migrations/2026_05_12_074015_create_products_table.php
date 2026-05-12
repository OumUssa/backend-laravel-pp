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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title', 100);
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->text('image_url');
            $table->unsignedBigInteger('type_product_id');
            $table->unsignedBigInteger('pet_category_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_product_id')->references('id')->on('type_products')->onDelete('cascade');
            $table->foreign('pet_category_id')->references('id')->on('pet_categories')->onDelete('cascade');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
