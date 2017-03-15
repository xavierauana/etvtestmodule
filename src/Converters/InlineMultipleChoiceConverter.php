<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 12:32 AM
 */

namespace Anacreation\Etvtest\Converters;


use Anacreation\Etvtest\Factory\QuestionConverterFactory;
use Anacreation\Etvtest\Models\Question;
use Illuminate\Support\Collection;

class InlineMultipleChoiceConverter extends AbstractConverter
{


    /**
     * @param Question $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['sub_questions'] = $this->getSubQuestions($subject->subQuestions);

        return $data;
    }

    private function getSubQuestions(Collection $subQuestions) {

        $converter = QuestionConverterFactory::make($subQuestions->first());
        return $converter->convert($subQuestions);

        $questionsArray = [];
        foreach ($subQuestions as $question) {

            //            $className = "Anacreation\\Etvtest\\Converters\\".$question->QuestionType->code."Converter";
            //            /** @var \Anacreation\Etvtest\Converters\ConverterInterface $converter */
            //            $converter = app($className);

            $converter = QuestionConverterFactory::make($question);
            $questionsArray[] = $converter->convert($question);
        }

        return $questionsArray;
    }
}