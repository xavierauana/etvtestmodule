<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 10:18 PM
 */

namespace Anacreation\Etvtest\Graders;


use Anacreation\Etvtest\Models\Question;

class GraderManger
{
    public static function grade(Question $question, array $answers){
        $class = "\\Anacreation\\Etvtest\\Graders\\{$question->QuestionType->code}Grader";
        $grader = app($class);
        return $grader->grade($question, $answers);
    }

}