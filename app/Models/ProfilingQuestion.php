<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfilingQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'type',
    ];

    /**
     * Get the related answers.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(ProfilingQuestionAnswer::class)->select([
            'id',
            'profiling_question_id',
            'answer',
        ]);
    }
}
