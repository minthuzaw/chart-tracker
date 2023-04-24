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
        Schema::create('income_and_outcomes', function (Blueprint $table) {
            $table->id();
            $table->string('topic');
            $table->date('date');
            $table->integer('amount');
            $table->enum('type', ['income', 'outcome']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_and_outcomes');
    }
};
