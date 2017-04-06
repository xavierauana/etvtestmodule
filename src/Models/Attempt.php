<?php

namespace Anacreation\Etvtest\Models;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    protected $fillable = [
        'test_id',
        'attempt',
        'score'
    ];

    public function setAttemptAttribute($value) {
        $this->attributes['attempt'] = serialize($value);
    }

    public function getAttemptAttribute($value) {
        return unserialize($value);
    }
}
