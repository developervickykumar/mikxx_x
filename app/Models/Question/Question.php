<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'type',
        'title',
        'content',
        'options',
        'correct_answer',
        'marks',
        'time_limit',
        'image_url',
        'order'
    ];

    protected $casts = [
        'options' => 'json',
        'correct_answer' => 'json',
        'marks' => 'integer',
        'time_limit' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the exam that owns the question.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the answers for the question.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
} 