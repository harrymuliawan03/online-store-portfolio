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
            $table->string('name');
            $table->unsignedBigInteger('users_id');
            $table->integer('price');
            $table->longText('description');
            $table->unsignedBigInteger('categories_id');
            $table->softDeletes();
            $table->timestamps();

            
            $table->foreign("users_id")->references("id")->on("users");
            $table->foreign("categories_id")->references("id")->on("categories");
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