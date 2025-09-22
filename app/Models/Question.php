<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'correct_answer',
        'explanation',
        'is_active',
        'order'
    ];

    protected $casts = [
        'correct_answer' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Scope for active questions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    /**
     * Get random questions
     */
    public function scopeRandom($query, $count = 10)
    {
        return $query->inRandomOrder()->limit($count);
    }


    /**
     * Get correct answer text
     */
    public function getCorrectAnswerTextAttribute()
    {
        return $this->correct_answer ? 'نعم' : 'لا';
    }
}
