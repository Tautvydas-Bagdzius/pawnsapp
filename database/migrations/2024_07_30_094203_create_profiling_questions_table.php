<?php

use App\Enums\ProfilingQuestionTypes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiling_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->enum('type', ProfilingQuestionTypes::values());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiling_questions');
    }
};
