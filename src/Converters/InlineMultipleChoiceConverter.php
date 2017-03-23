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
        $questionsArray = [];

        if($subQuestions->count() > 0){

            $converter = QuestionConverterFactory::make($subQuestions->first());

            return $converter->convert($subQuestions);
        }

        return $questionsArray;
    }
}