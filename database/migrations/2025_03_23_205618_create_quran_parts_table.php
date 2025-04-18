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
        Schema::create('quran_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("surah_id")->constrained("surahs");
            $table->integer("part");
            $table->integer("verses_in_part");
            $table->integer("total_verses");
            $table->integer("total_verses_in_part");
            $table->float("percentage");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quran_parts');
    }
};
