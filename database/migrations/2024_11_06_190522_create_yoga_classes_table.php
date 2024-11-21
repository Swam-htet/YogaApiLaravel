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
        Schema::create('yoga_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yoga_course_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('teacher');
            $table->text('additional_comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yoga_classes');
    }
};
