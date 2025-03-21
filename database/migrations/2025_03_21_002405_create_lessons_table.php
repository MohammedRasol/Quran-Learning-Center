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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string("topic");
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("classroom_id")->constrained("classrooms");
            $table->timestamp("started_at")->default(date("Y-m-d H:i:s"));
            $table->timestamp("finished_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
