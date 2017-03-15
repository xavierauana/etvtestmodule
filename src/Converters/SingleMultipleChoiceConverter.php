<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 12:53 AM
 */

namespace Anacreation\Etvtest\Converters;


class SingleMultipleChoiceConverter extends AbstractConverter
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['choices'] = (new ChoiceConverter())->convert($subject->choices);

        return $data;
    }
}