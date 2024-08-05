<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'content' => $this->content,
            'type' => $this->type,
            'topic_id' => $this->topic_id,
            'topic_name' => $this->topic->name,
            'answers' => $this->answers
        ];
    }
}
