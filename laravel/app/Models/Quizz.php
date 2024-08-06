<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quizz extends Model
{
    use HasFactory, QueryScopes;

    protected $table = 'quizzes';
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

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function results()
    {
        return $this->hasMany(ResultAnswer::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->canonical = self::generateUniqueSlug($model->title);
        });

        static::updating(function ($model) {
            $model->canonical = self::generateUniqueSlug($model->title, $model->id);
        });
    }

    public static function generateUniqueSlug($title, $excludeId = null)
    {
        $canonical = Str::slug($title);
        $originalCanonical = $canonical;
        $count = 1;

        while (self::where('canonical', $canonical)
            ->where('id', '!=', $excludeId)
            ->exists()
        ) {
            $canonical = "{$originalCanonical}-" . $count++;
        }

        return $canonical;
    }
}
