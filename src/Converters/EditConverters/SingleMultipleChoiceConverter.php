<?php
/**
 * Author: Xavier Au
 * Date: 19/2/2017
 * Time: 5:06 PM
 */

namespace Anacreation\Etvtest\Converters\EditConverters;


use Anacreation\Etvtest\Converters\AbstractConverter;
use Anacreation\Etvtest\Converters\ChoiceConverter;

class SingleMultipleChoiceConverter extends AbstractConverter
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['id'] = $subject->id;
        $data['prefix'] = $subject->prefix;
        $data['choices'] = $this->createChoiceWithCorrectnessIndicator($subject);
        $data['content'] = $subject->content;
        $data['is_active'] = !!$subject->is_active;
        $data['page_number'] = $subject->page_number;
        $data['question_type_id'] = $subject->QuestionType->id;

        return $data;
    }

    /**
     * @param $subject
     * @param $data
     * @return mixed
     */
    protected function createChoiceWithCorrectnessIndicator($subject): array {
        $dataArray = [];
        foreach ((new ChoiceConverter())->convert($subject->choices) as $choiceData) {
            $choiceData['is_corrected'] = in_array($choiceData['id'], $subject->answer->content);
            $dataArray[] = $choiceData;
        }

        return $dataArray;
    }
}