<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = ['question_id', 'content', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
