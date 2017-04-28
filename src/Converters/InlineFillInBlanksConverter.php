<?php
/**
 * Author: Xavier Au
 * Date: 8/2/2017
 * Time: 2:34 PM
 */

namespace Anacreation\Etvtest\Converters;


use Illuminate\Support\Collection;

class InlineFillInBlanksConverter extends AbstractConverter
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data['sub_questions'] = $this->getSubQuestions($subject->subQuestions);

        return $data;
    }

    private function getSubQuestions(Collection $subQuestions) {
        $questionsArray = [];
        if ($subQuestions->count() > 0) {

            $converter = QuestionConverterFactory($subQuestions->first());

            return $converter->convert($subQuestions);
        }

        return $questionsArray;
    }
}