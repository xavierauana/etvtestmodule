<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 10:18 PM
 */

namespace Anacreation\Etvtest\Graders;


use Anacreation\Etvtest\Factory\QuestionGraderFactory;
use Anacreation\Etvtest\Models\Question;

class GraderManger
{
    public static function grade(Question $question, array $answers) {
        $grader = QuestionGraderFactory::make($question);

        return $grader->grade($question, $answers);
    }
}