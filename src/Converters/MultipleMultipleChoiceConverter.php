<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 12:47 AM
 */

namespace Anacreation\Etvtest\Converters;



class MultipleMultipleChoiceConverter extends AbstractConverter
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['choices'] = (new ChoiceConverter())->convert($subject->choices);
        $data['content'] = $subject->content;
        $data['prefix'] = $subject->prefix;
        $data['question_type_id'] = $subject->QuestionType->id;
        $data['id'] = $subject->id;

        return $data;
    }

}