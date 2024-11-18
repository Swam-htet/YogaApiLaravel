<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class YogaCourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'day_of_week' => $this->day_of_week,
            'time_of_course' => $this->time_of_course,
            'capacity' => $this->capacity,
            'duration' => $this->duration,
            'price_per_class' => $this->price_per_class,
            'type_of_class' => $this->type_of_class,
            'description' => $this->description,
            'class_mode' => $this->class_mode,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
