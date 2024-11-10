<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\YogaCourse;
use App\Models\YogaClass;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 10 yoga courses
        YogaCourse::factory(10)->create();

        // 20 yoga classes
        YogaCourse::all()->each(function ($course) {
            $course->classes()->createMany(
                YogaClass::factory(2)->make()->toArray()
            );
        });
    }
}
