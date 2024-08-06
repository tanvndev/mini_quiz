<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = ['type', 'topic_id', 'content'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quizz::class);
    }

    public function result_answers()
    {
        return $this->hasMany(ResultAnswer::class);
    }
}
