<?php

namespace Anacreation\Etvtest\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Test extends Model
{
    protected $fillable = [
        'title',
        'is_active',
        'order'
    ];

    public function testable() {
        return $this->morphTo();
    }

    public function questions() {
        return $this->belongsToMany(Question::class);
    }
}
