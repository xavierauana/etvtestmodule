<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 6:00 PM
 */

namespace Anacreation\Etvtest\Converters;


class SingleFillInBlanksConverter extends AbstractConverter
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['id'] = $subject->id;
        $data['prefix'] = $subject->prefix;
        $data['content'] = $subject->content;
        $data['page_number'] = $subject->page_number;
        $data['question_type_id'] = $subject->QuestionType->id;


        return $data;
    }
}