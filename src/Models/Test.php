<?php

namespace Anacreation\Etvtest\Models;

use Anacreation\Etvtest\Observers\TestObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Test extends Model
{
    protected $fillable = [
        'title',
        'is_active',
        'order'
    ];

    public static function boot() {
        parent::boot();

        if (config('test.test_observation')) {
            Test::observe(TestObserver::class);
        }
    }

    public function questions() {
        return $this->belongsToMany(Question::class);
    }

    public function addQuestion(Question $question) {
        return $this->questions()->save($question);
    }

    private function testableRelation(string $objectFullName): Relation {
        return $this->morphedByMany($objectFullName, 'testable');
    }

    public function __get($key) {
        return parent::__get($key) ?? $this->getTestableRelation($key);
    }

    private function getTestableRelation($key): ?Collection {
        $mapping = config('test.testable_class');
        $result = null;
        if (in_array($key, array_keys($mapping))) {
            try {
                $result = $this->testableRelation($mapping[$key])->get();
            } catch (\Exception $e) {
                Log::error("Unable to get inverse testable relation");
                Log::error($e->getMessage());
            } catch (\Error $e) {
                Log::error("Unable to get inverse testable relation");
                Log::error($e->getMessage());
            } finally {
                return $result;
            }
        }

        return $result;
    }
}
