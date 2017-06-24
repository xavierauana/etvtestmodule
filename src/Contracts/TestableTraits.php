<?php
/**
 * Author: Xavier Au
 * Date: 11/1/2017
 * Time: 6:14 PM
 */

namespace Anacreation\Etvtest\Contracts;

use  Anacreation\Etvtest\Models\Test;
use Illuminate\Database\Eloquent\Relations\Relation;

trait TestableTraits
{
    public function tests(): Relation {
        return $this->morphToMany(Test::class, 'testable');
    }
}