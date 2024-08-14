<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultAnswer extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'result_id',
        'quiz_id',
        'question_id',
        'answer_id',
        'is_correct',
    ];

    public $timestamps = false;

    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function quizz()
    {
        return $this->belongsTo(Quizz::class);
    }
}
