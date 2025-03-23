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
        Schema::create('student_lesson_recitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained("students");
            $table->foreignId("lesson_id")->constrained("lessons");
            $table->integer("surah")->nullable();
            $table->integer("from_verse")->nullable();
            $table->integer("to_verse")->nullable();
            $table->integer("rate")->nullable();
            $table->text("notes")->nullable();
            $table->timestamp("recitation_date")->nullable();
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('student_lesson_recitations');
    }
};
