<?php
/**
 * Author: Xavier Au
 * Date: 11/1/2017
 * Time: 6:14 PM
 */

namespace Anacreation\Etvtest\Contracts;

use  Anacreation\Etvtest\Models\Test;

trait TestableTraits
{
    public function tests() {
        return $this->morphMany(Test::class, 'testable');
    }
}