<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category'); // Kategori laporan
            $table->string('photo_1'); // Foto wajib
            $table->string('photo_2');
            $table->string('photo_3');
            $table->text('description'); // Keterangan
            $table->string('kota'); // Lokasi
            $table->string('kecamatan');
            $table->string('address');
            $table->enum('status', ['pending', 'in_progress', 'accepted', 'rejected', 'completed'])->default('pending');
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
        Schema::dropIfExists('reports');
    }
}
