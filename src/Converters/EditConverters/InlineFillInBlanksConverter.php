<?php
/**
 * Author: Xavier Au
 * Date: 8/2/2017
 * Time: 2:34 PM
 */

namespace Anacreation\Etvtest\Converters\EditConverters;


use Anacreation\Etvtest\Converters\AbstractConverter;


class InlineFillInBlanksConverter extends AbstractConverter
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['sub_questions'] = (new SingleFillInBlanksConverter())->convert($subject->subQuestions);

        return $data;
    }
}