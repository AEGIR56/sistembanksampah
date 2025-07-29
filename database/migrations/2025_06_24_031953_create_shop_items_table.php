<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // database/migrations/xxxx_xx_xx_create_shop_items_table.php
    public function up()
    {
        Schema::create('shop_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('point_cost');
            $table->integer('stock');
            $table->timestamps();
            $table->string('description')->nullable();
        });

        Schema::create('shop_item_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_item_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });

        Schema::create('shop_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shop_item_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('total_point');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_items');
    }
};
