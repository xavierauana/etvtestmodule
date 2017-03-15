<?php
/**
 * Author: Xavier Au
 * Date: 15/3/2017
 * Time: 6:20 PM
 */

namespace Anacreation\Etvtest\Factory;


use Anacreation\Etvtest\Converters\ConverterInterface;
use Anacreation\Etvtest\Converters\ConverterType;

class QuestionConverterFactory
{
    public static function make(Question $question, string $ConverterType= ConverterType::ATTEMPT): ConverterInterface  {

        if($ConverterType == ConverterType::ATTEMPT){
            $className = "Anacreation\\Etvtest\\Converters\\" . $question->QuestionType->code . "Converter";
        }elseif($ConverterType == ConverterType::EDIT){
            $className = "Anacreation\\Etvtest\\Converters\\EditConverters\\" . $question->QuestionType->code . "Converter";
        }

        return app($className);
    }
}