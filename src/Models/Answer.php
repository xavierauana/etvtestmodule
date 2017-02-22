<?php

namespace Anacreation\Etvtest\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'content',
        'is_ordered',
        'is_required_all'
    ];

    public function setContentAttribute($value) {
        $value = is_array($value) ? $value : [$value];
        $this->attributes['content'] = serialize($value);
    }

    public function getContentAttribute($value) {
        $answer = unserialize($value);

        return is_array($answer) ? $answer : [$answer];
    }
}
