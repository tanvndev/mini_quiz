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
}
