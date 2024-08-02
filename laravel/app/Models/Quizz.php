<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizz extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'canonical',
        'topic_id',
        'publish',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
