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
        Schema::create('students_absent', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained("students")->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained("lessons")->cascadeOnDelete();
            $table->date('absence_date');
            $table->string('reason', 255)->nullable();
            $table->timestamps();
            // Define composite primary key
            $table->primary(['student_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_absent');
    }
};
