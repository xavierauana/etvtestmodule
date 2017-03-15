<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 1:02 AM
 */

namespace Anacreation\Etvtest\Converters;


class ReOrderConverter extends AbstractConverter
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['choices'] = (new ChoiceConverter())->convert($subject->choices);

        return $data;
    }
}