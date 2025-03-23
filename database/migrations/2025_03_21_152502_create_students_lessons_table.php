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
        Schema::create('students_lessons', function (Blueprint $table) {
            $table->foreignId("student_id")->constrained("students");
            $table->foreignId("lesson_id")->constrained("lessons");
            $table->primary(["student_id", "lesson_id"]); // Composite primary key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_lessons');
    }
};
