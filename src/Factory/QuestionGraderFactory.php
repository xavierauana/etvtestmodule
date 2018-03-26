<?php
/**
 * Author: Xavier Au
 * Date: 26/3/2018
 * Time: 1:16 PM
 */

namespace Anacreation\Etvtest\Factory;


use Anacreation\Etvtest\Graders\GraderInterface;
use Anacreation\Etvtest\Models\Question;

class QuestionGraderFactory
{
    public static function make(Question $question): GraderInterface {

        $class = "\\Anacreation\\Etvtest\\Graders\\{$question->QuestionType->code}Grader";

        return app($class);
    }
}