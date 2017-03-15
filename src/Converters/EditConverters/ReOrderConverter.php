<?php
/**
 * Author: Xavier Au
 * Date: 20/2/2017
 * Time: 5:08 PM
 */

namespace Anacreation\Etvtest\Converters\EditConverters;


use Anacreation\Etvtest\Converters\AbstractConverter;
use Anacreation\Etvtest\Converters\ChoiceConverter;

class ReOrderConverter extends AbstractConverter
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['answer'] = $subject->answer->content;
        $data['choices'] = (new ChoiceConverter())->convert($subject->choices);
        $data['is_active'] = !!$subject->is_active;

        return $data;
    }
}