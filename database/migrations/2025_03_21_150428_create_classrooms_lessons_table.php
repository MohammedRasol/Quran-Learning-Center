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
        Schema::create('classrooms_lessons', function (Blueprint $table) {
            $table->foreignId("classroom_id")->constrained("classrooms");
            $table->foreignId("lesson_id")->constrained("lessons");
            $table->primary(["classroom_id", "lesson_id"]); // Composite primary key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms_lessons');
    }
};
