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
        $data['prefix'] = $subject->prefix;
        $data['content'] = $subject->content;
        $data['question_type_id'] = $subject->QuestionType->id;
        $data['id'] = $subject->id;

        return $data;
    }

    private function getSubQuestions(Collection $subQuestions) {
        $questionsArray = [];
        foreach ($subQuestions as $question) {
            $converter = QuestionConverterFactory($question);
            $questionsArray[] = $converter->convert($question);
        }

        return $questionsArray;
    }
}