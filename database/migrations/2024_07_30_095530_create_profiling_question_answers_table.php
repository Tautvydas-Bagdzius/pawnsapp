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
        Schema::create('profiling_question_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profiling_question_id');
            $table->string('answer');
            $table->timestamps();

            $table->foreign('profiling_question_id')->references('id')->on('profiling_questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiling_question_answers');
    }
};
