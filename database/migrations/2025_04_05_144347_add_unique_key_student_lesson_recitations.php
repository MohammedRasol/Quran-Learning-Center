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
        Schema::table('student_lesson_recitations', function (Blueprint $table) {
            $table->unique(['student_id', 'lesson_id', 'surah_id', 'from_verse'],'slr_unique_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_lesson_recitations', function (Blueprint $table) {
            //
        });
    }
};
