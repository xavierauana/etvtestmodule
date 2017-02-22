<?php
/**
 * Author: Xavier Au
 * Date: 3/2/2017
 * Time: 10:29 PM
 */

namespace Anacreation\Etvtest\Converters;



use Illuminate\Support\Collection;

class ComprehensionConverter extends AbstractConverter
{


    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    protected function _convert($subject) {
        $data = [];

        $data['sub_questions'] = $this->getSubQuestions($subject->subQuestions);
        $data['content'] = $subject->content;
        $data['question_type_id'] = $subject->QuestionType->id;
        $data['id'] = $subject->id;

        return $data;
    }

    private function getSubQuestions(Collection $subQuestions) {
        $questionsArray = [];
        foreach ($subQuestions as $question){
            $className = "Anacreation\\Etvtest\\Converters\\".$question->QuestionType->code."Converter";

            /** @var \Anacreation\Etvtest\Converters\ConverterInterface $converter */
            $converter = app($className);
            $questionsArray[] = $converter->convert($question);
        }
        return $questionsArray;
    }


}