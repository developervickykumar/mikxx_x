<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'user_id',
        'score',
        'total_marks',
        'status',
        'time_spent',
        'completed_at'
    ];

    protected $casts = [
        'score' => 'float',
        'total_marks' => 'integer',
        'time_spent' => 'integer',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the exam for this result.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the user for this result.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the answers for this result.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Calculate the percentage score.
     */
    public function getPercentageAttribute()
    {
        if ($this->total_marks > 0) {
            return round(($this->score / $this->total_marks) * 100, 2);
        }
        return 0;
    }

    /**
     * Determine if the result is a pass.
     */
    public function getIsPassAttribute()
    {
        return $this->percentage >= $this->exam->passing_marks;
    }
} 