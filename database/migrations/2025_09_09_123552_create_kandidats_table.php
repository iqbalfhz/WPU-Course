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
        Schema::create('kandidats', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('usia');
            $table->string('email');
            $table->float('nilai_akademik')->nullable();
            $table->float('tes_kompetensi_teknis')->nullable();
            $table->float('tes_psikotes')->nullable();
            $table->float('tes_kepribadian')->nullable();
            $table->float('soft_skill')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandidats');
    }
};
