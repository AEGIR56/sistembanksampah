<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportPickupsTable extends Migration
{
    public function up(): void
    {
        Schema::create('report_pickups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pickup_id');
            $table->unsignedBigInteger('staff_id');
            $table->string('berat_staff');
            $table->string('alasan_laporan');
            $table->string('gambar_1')->nullable();
            $table->string('gambar_2')->nullable();
            $table->string('gambar_3')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status_laporan', ['selesai', 'ditolak']);
            $table->timestamps();

            // Foreign Keys (optional, jika kamu ingin constraint)
            $table->foreign('pickup_id')->references('id')->on('pickups')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_pickups');
    }
};
