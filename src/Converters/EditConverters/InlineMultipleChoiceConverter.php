<?php
/**
 * Author: Xavier Au
 * Date: 19/2/2017
 * Time: 5:25 PM
 */

namespace Anacreation\Etvtest\Converters\EditConverters;


use Anacreation\Etvtest\Converters\AbstractConverter;

class InlineMultipleChoiceConverter extends AbstractConverter
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];
        $data['sub_questions'] = (new SingleMultipleChoiceConverter())->convert($subject->subQuestions);
        $data['prefix'] = $subject->prefix;
        $data['content'] = $subject->content;
        $data['question_type_id'] = $subject->QuestionType->id;
        $data['is_active'] = !!$subject->is_active;
        $data['id'] = $subject->id;

        return $data;
    }
}