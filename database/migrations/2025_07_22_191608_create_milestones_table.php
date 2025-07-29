<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilestonesTable extends Migration
{
    public function up()
    {
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type');
            $table->boolean('achieved')->default(false);
            $table->timestamp('achieved_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('milestones');
    }
}
