<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tes_online', function (Blueprint $table) {
            $table->id();

            // kompetensi_teknis | psikotes | kepribadian
            $table->string('jenis')->index();
            $table->json('pertanyaan')->nullable();
            $table->json('opsi')->nullable();
            $table->json('jawaban_benar')->nullable();

            $table->timestamps();
            // $table->softDeletes(); // aktifkan kalau ingin soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tes_online');
    }
};
