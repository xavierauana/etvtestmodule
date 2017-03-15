<?php

namespace Anacreation\Etvtest\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'content',
        'question_type_id',
        'is_active',
        'is_fractional',
        'prefix',
        "page_number",
        'order'
    ];

    public function QuestionType() {
        return $this->belongsTo(QuestionType::class);
    }

    public function tests() {
        return $this->belongsToMany(Test::class);
    }

    public function answer() {
        return $this->hasOne(Answer::class);
    }

    public function choices() {
        return $this->hasMany(Choice::class);
    }

    public function subQuestions() {
        return $this->hasMany(Question::class, 'group_id');
    }

    public function scopeIsActive($query) {
        return $query->whereIsActive(true);
    }

    public function scopeOrdered($query): Builder {
        return $query->orderBy(['order'=>'asc', 'created_at'=>'desc']);
    }
}
