<?php
/**
 * Author: Xavier Au
 * Date: 13/3/2017
 * Time: 8:25 PM
 */

namespace Anacreation\Etvtest\Factory;


use Anacreation\Etvtest\Contracts\CreateQuestionInterface;
use Anacreation\Etvtest\Models\QuestionType;

class QuestionCreatorFactory
{

    /**
     * @param int $questionTypeId
     * @return \Anacreation\Etvtest\Contracts\CreateQuestionInterface
     * @throws \Exception
     */
    public static function make(int $questionTypeId): CreateQuestionInterface {

        $type = QuestionType::findOrFail($questionTypeId);

        $object = app("Anacreation\\Etvtest\\QuestionType\\" . $type->code);

        if ($object instanceof CreateQuestionInterface) {
            return $object;
        }

        throw new \Exception("No Class {$type->code} fulfill interface.");
    }
}