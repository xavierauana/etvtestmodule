<?php
/**
 * Author: Xavier Au
 * Date: 20/1/2017
 * Time: 3:59 AM
 */

namespace Anacreation\Etvtest\Contracts;

use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\Test;

interface CreateQuestionInterface
{
    /**
     * @param array     $inputs
     * @param \Anacreation\Etvtest\Models\Test $test
     * @return Question
     */
    public function create(array $inputs, Test $test);
}