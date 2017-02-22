<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 9:01 PM
 */

namespace Anacreation\Etvtest\Graders;


use Anacreation\Etvtest\Models\Question;

interface GraderInterface
{
    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array         $answer
     * @return array
     */
    public function grade(Question $question, array $answer);
}