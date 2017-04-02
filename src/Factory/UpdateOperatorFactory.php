<?php
/**
 * Author: Xavier Au
 * Date: 17/2/2017
 * Time: 4:29 PM
 */

namespace Anacreation\Etvtest\Factory;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
use Anacreation\Etvtest\Models\Question;

class UpdateOperatorFactory
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @return \Anacreation\Etvtest\Contracts\UpdateOperatorInterface
     */
    public static function make(Question $question): UpdateOperatorInterface {
        $questionType = $question->QuestionType;
        $prefix = "\\Anacreation\\Etvtest\\UpdateQuestion\\Update";
        $operator = resolve($prefix . $questionType->code, ['question' => $question]);

        return $operator;
    }
}