<?php
/**
 * Author: Xavier Au
 * Date: 15/3/2017
 * Time: 6:20 PM
 */

namespace Anacreation\Etvtest\Factory;


use Anacreation\Etvtest\Converters\ConverterInterface;
use Anacreation\Etvtest\Converters\ConverterType;
use Anacreation\Etvtest\Models\Question;

class QuestionConverterFactory
{
    public static function make(Question $question,
        string $ConverterType = ConverterType::ATTEMPT): ConverterInterface {

        $className = null;
        if ($ConverterType == ConverterType::ATTEMPT) {
            $className = "Anacreation\\Etvtest\\Converters\\" . $question->QuestionType->code . "Converter";
        } elseif ($ConverterType == ConverterType::EDIT) {
            $className = "Anacreation\\Etvtest\\Converters\\EditConverters\\" . $question->QuestionType->code . "Converter";
        }

        if ($className == null) {
            throw new \Exception("No Converter Found!");
        }

        return app($className);

    }
}