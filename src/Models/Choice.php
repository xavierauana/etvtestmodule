<?php

namespace Anacreation\Etvtest\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $fillable = [
        'content'
    ];

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
