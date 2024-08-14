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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('canonical', 100)->unique();
            $table->foreignId('topic_id')->constrained('topics')->cascadeOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('publish')->default(1)->comment('1: Active, 2: Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
