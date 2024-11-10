<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class YogaClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // 'yoga_course_id' => $this->yoga_course_id,
            'date' => $this->date,
            'teacher' => $this->teacher,
            'additional_comments' => $this->additional_comments,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            'course' => new YogaCourseResource($this->whenLoaded('course'))
        ];
  }
}
