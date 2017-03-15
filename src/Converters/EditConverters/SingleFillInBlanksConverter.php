<?php
/**
 * Author: Xavier Au
 * Date: 20/2/2017
 * Time: 4:44 PM
 */

namespace Anacreation\Etvtest\Converters\EditConverters;


use Anacreation\Etvtest\Converters\AbstractConverter;
use Anacreation\Etvtest\Converters\ChoiceConverter;

class SingleFillInBlanksConverter extends AbstractConverter
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];


        $data['choices'] = (new ChoiceConverter())->convert($subject->choices);
        $data['is_active'] = !!$subject->is_active;

        return $data;
    }
}