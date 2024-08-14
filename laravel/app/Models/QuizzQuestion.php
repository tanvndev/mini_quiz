<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizzQuestion extends Model
{
    use HasFactory, QueryScopes;

    public function quizz()
    {
        return $this->belongsTo(Quizz::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
