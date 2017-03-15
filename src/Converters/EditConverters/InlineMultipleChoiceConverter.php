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

        $data['is_active'] = !!$subject->is_active;
        $data['sub_questions'] = (new SingleMultipleChoiceConverter())->convert($subject->subQuestions);

        return $data;
    }
}