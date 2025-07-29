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
    public function up()
    {
        Schema::create('pickup_reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pickup_id')->constrained()->onDelete('cascade');
        $table->text('notes')->nullable();
        $table->string('photo')->nullable(); // optional
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
        Schema::dropIfExists('pickup_reports');
    }
};
