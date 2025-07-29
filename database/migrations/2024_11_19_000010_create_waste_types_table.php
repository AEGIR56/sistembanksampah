<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasteTypesTable extends Migration
{
    public function up()
    {
        Schema::create('waste_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedInteger('points_per_kg');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waste_types');
    }
}
