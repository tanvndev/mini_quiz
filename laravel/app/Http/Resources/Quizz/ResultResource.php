<?php

namespace App\Http\Resources\Quizz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            'score' => $this->score,
            'correct' => $this->correct,
            'user_name' => $this->user->fullname ?? '',
            'duration' => convertMilliseconds($this->duration),
            'quizz_name' => $this->quizz->title,
            'result_answers' => $this->result_answers,
        ];
    }
}
