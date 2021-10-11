<?php

use Anacreation\Etvtest\Converters\ConverterInterface;
use Anacreation\Etvtest\Converters\ConverterType;
use Anacreation\Etvtest\Models\Question;
use Illuminate\Support\Facades\App;

function QuestionConverterFactory(Question $question, string $ConverterType = ConverterType::ATTEMPT): ConverterInterface
{

    if ($ConverterType == ConverterType::ATTEMPT) {
        $className = "Anacreation\\Etvtest\\Converters\\" . $question->QuestionType->code . "Converter";
    } elseif ($ConverterType == ConverterType::EDIT) {
        $className = "Anacreation\\Etvtest\\Converters\\EditConverters\\" . $question->QuestionType->code . "Converter";
    }

    return app($className);
}
