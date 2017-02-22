<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 6:02 PM
 */

namespace Anacreation\Etvtest\Converters;


class MultipleFillInBlanksConverter extends AbstractConverter
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['number_of_fields'] = count($subject->choices);
        $data['prefix'] = $subject->prefix;
        $data['content'] = $subject->content;
        $data['is_fractional'] = !!$subject->is_fractional;
        $data['question_type_id'] = $subject->QuestionType->id;
        $data['id'] = $subject->id;

        return $data;
    }
}