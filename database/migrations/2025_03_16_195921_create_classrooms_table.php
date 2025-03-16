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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId("group_id")->constrained("groups")->cascadeOnDelete();
            $table->string("name");
            $table->string("nick_name")->nullable();
            $table->date("start_date")->nullable();
            $table->date("closed_date")->nullable();
            $table->string("image")->nullable();
            $table->integer('graduated')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
