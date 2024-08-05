<?php

namespace App\Http\Resources\Quizz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizzResource extends JsonResource
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
            'key' => $this->id,
            'image' => $this->image,
            'canonical' => $this->canonical,
            'title' => $this->title,
            'description' => $this->description,
            'publish' => $this->publish,
            'topic_name' => $this->topic->name,
            'topic_id' => $this->topic_id,
            'questions' => $this->questions
        ];
    }
}
