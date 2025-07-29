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
        Schema::create('calendar_days', function (Blueprint $table) {
    $table->id();
    $table->date('date')->unique();
    $table->enum('status', ['tersedia', 'penuh', 'libur']);
    $table->foreignId('staff_id')->nullable()->constrained('users');
    $table->timestamps();
});}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_days');
    }
};
