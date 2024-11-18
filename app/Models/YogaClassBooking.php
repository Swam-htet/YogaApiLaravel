<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YogaClassBooking extends Model
{
    /** @use HasFactory<\Database\Factories\YogaClassBookingFactory> */
    use HasFactory;

    protected $fillable = [
        'yoga_class_id',
        'email',
    ];

    public function yogaClass()
    {
        return $this->belongsTo(YogaClass::class);
    }
}
