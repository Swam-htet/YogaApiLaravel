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
        Schema::create('yoga_courses', function (Blueprint $table) {
            $table->id();
            $table->string('day_of_week');
            $table->string('time_of_course');
            $table->integer('capacity');
            $table->integer('duration');
            $table->decimal('price_per_class', 8, 2);
            $table->string('type_of_class');
            $table->text('description')->nullable();
            $table->string('mode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yoga_courses');
    }
};
