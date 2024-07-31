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
        Schema::create('global_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedInteger('num_transactions_created')->default(0);
            $table->unsignedInteger('num_transactions_claimed')->default(0);
            $table->decimal('usd_amount_claimed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_stats');
    }
};
