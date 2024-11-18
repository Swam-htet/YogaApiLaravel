<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class YogaClassDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'teacher' => $this->teacher,
            'additional_comments' => $this->additional_comments,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'course' => new YogaCourseResource($this->whenLoaded('course')),
        ];
    }
}
