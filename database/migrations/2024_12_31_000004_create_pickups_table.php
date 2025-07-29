<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pickups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('username')->nullable();
            $table->date('pickup_date');
            $table->string('time_slot');
            $table->text('address');
            $table->foreignId('waste_type_id')->nullable()->constrained('waste_types')->onDelete('set null');
            $table->float('weight');
            $table->string('status')->nullable()->change();
            $table->timestamps();

            // Relasi dengan tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('pickups');
    }
}
