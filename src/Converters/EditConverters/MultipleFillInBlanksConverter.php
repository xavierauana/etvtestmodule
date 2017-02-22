<?php
/**
 * Author: Xavier Au
 * Date: 20/2/2017
 * Time: 4:54 PM
 */

namespace Anacreation\Etvtest\Converters\EditConverters;


use Anacreation\Etvtest\Converters\AbstractConverter;
use Anacreation\Etvtest\Converters\ChoiceConverter;

class MultipleFillInBlanksConverter extends AbstractConverter
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['choices'] = (new ChoiceConverter())->convert($subject->choices);
        $data['prefix'] = $subject->prefix;
        $data['content'] = $subject->content;
        $data['question_type_id'] = $subject->QuestionType->id;
        $data['is_active'] = !!$subject->is_active;
        $data['is_fractional'] = !!$subject->is_fractional;
        $data['is_ordered'] = !!$subject->answer->is_ordered;
        $data['id'] = $subject->id;

        return $data;
    }
}