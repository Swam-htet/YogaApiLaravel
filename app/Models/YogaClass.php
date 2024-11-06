<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\YogaCourse;

class YogaClass extends Model
{
    /** @use HasFactory<\Database\Factories\YogaClassFactory> */
    use HasFactory;

    protected $table = 'yoga_classes';

    protected $fillable = [
        'yoga_course_id',
        'date',
        'teacher',
        'additional_comments',
    ];

    public function course()
    {
        return $this->belongsTo(YogaCourse::class, 'yoga_course_id');
    }
}
