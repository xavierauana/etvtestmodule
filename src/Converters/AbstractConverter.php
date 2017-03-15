<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 12:36 AM
 */

namespace Anacreation\Etvtest\Converters;


use Illuminate\Support\Collection;

abstract class AbstractConverter implements ConverterInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection $subject
     * @return array
     */
    public function convert($subject): array {
        $data = [];
        if ($subject instanceof Collection) {
            if ($subject->count() > 0) {
                $subjects = $subject;
                foreach ($subjects as $subject) {
                    $data[] = $this->getCommonAttributes($subject, $this->_convert($subject));
                }
            }
        } else {
            $data[] = $this->getCommonAttributes($subject, $this->_convert($subject));
        }

        return $data;

    }

    private function getCommonAttributes($subject, $data): array {
        $data['id'] = $subject->id;
        $data['prefix'] = $subject->prefix;
        $data['content'] = $subject->content;
        $data['order'] = $subject->order;
        $data['page_number'] = $subject->page_number;
        $data['question_type_id'] = $subject->QuestionType->id;
        return $data;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    abstract protected function _convert($subject);
}