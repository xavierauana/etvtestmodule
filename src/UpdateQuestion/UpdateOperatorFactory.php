<?php
/**
 * Author: Xavier Au
 * Date: 17/2/2017
 * Time: 4:29 PM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
use Anacreation\Etvtest\Models\Question;
use Illuminate\Support\Facades\App;

class UpdateOperatorFactory
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @return \Anacreation\Etvtest\Contracts\UpdateOperatorInterface
     */
    public static function make(Question $question): UpdateOperatorInterface {
        $questionType = $question->QuestionType;
        $prefix = "\\Anacreation\\Etvtest\\UpdateQuestion\\Update";
        $operator = App::make($prefix . $questionType->code);
        return $operator;
    }
}