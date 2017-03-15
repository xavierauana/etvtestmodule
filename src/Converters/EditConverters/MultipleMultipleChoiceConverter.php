<?php
/**
 * Author: Xavier Au
 * Date: 19/2/2017
 * Time: 5:18 PM
 */

namespace Anacreation\Etvtest\Converters\EditConverters;


use Anacreation\Etvtest\Converters\AbstractConverter;
use Anacreation\Etvtest\Converters\ChoiceConverter;

class MultipleMultipleChoiceConverter extends AbstractConverter
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['answer'] = $subject->answer->content;
        $data['choices'] = (new ChoiceConverter())->convert($subject->choices);
        $data['is_fractional'] = !!$subject->is_fractional;
        $data['is_required_all'] = !!$subject->answer->is_required_all;

        return $data;
    }
}