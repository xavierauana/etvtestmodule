<?php

namespace Anacreation\Etvtest\Models;

use Anacreation\Etvtest\Observers\ChoiceObserver;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $fillable = [
        'content'
    ];

    public static function boot() {
        parent::boot();
        if (config('choice_observation')) {
            Choice::observe(ChoiceObserver::class);
        }
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function setContentAttribute($value) {
        $this->attributes['content'] = trim(str_replace("&nbsp;", "", $value));
    }

    public function scopeLimitedInfo($query) {
        $query->select(['id', 'content', 'question_id']);
    }
}
