<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 12:41 AM
 */

namespace Anacreation\Etvtest\Converters;


class ChoiceConverter extends AbstractConverter
{

    /**
     * @param \Anacreation\Etvtest\Models\Choice $subject
     * @return array
     */
    protected function _convert($subject) {

        $data['content'] = $subject->content;
        $data['id'] = $subject->id;
        return $data;

    }
}