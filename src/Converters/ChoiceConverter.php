<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 12:41 AM
 */

namespace Anacreation\Etvtest\Converters;



use Illuminate\Support\Collection;

class ChoiceConverter implements ConverterInterface
{

    public function convert($subject): array {
        $data = [];
        if ($subject instanceof Collection) {
            if ($subject->count() > 0) {
                $subjects = $subject;
                foreach ($subjects as $subject) {
                    $data[] = $this->_convert($subject);
                }
            }
        } else {
            $data[] = $this->_convert($subject);
        }

        return $data;

    }

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