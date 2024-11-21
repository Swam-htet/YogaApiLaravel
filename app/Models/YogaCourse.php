<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YogaCourse extends Model
{
    /** @use HasFactory<\Database\Factories\YogaCourseFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'day_of_week',
        'time_of_course',
        'capacity',
        'duration',
        'price_per_class',
        'type_of_class',
        'description',
        'location',
    ];

    public function classes()
    {
        return $this->hasMany(YogaClass::class, 'yoga_course_id');
    }
}
