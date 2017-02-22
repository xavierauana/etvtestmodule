<?php
/**
 * Author: Xavier Au
 * Date: 27/1/2017
 * Time: 3:47 PM
 */

namespace Anacreation\Etvtest\QuestionType;


use Anacreation\Etvtest\Contracts\CreateQuestionInterface;
use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\QuestionType;
use Anacreation\Etvtest\Models\Test;

class InlineMultipleChoice implements CreateQuestionInterface
{

    /**
     * @param array     $inputs
     * @param \Anacreation\Etvtest\Models\Test $test
     * @return Question
     */
    public function create(array $inputs, Test $test) {

        /** @var Question $mainQuestion */
        $mainQuestion = $test->questions()->create($inputs);

        foreach ($inputs['titles'] as $title) {

            $subQuestion = $this->createSubQuestion($inputs, $mainQuestion, $title);

            foreach ($inputs['choices'] as $choice) {

                if (strpos(urldecode($choice['textareaId']), $title) > -1) {

                    $this->createChoice($subQuestion, $choice);
                }
            }
        }

        return $mainQuestion;
    }


    /**
     * @param $subQuestion
     * @param $choice
     */
    private function createChoice(Question $subQuestion, array $choice) {
        $newChoice = $subQuestion->choices()->create($choice);
        if ($choice["is_corrected"]) {
            $subQuestion->answer()->create([
                'content' => [$newChoice->id]
            ]);
        }
    }

    /**
     * @param array $inputs
     * @param       $mainQuestion
     * @param       $title
     * @return mixed
     */
    private function createSubQuestion(array $inputs, Question $mainQuestion, $title) {
        $subQuestion = $mainQuestion->subQuestions()->create([
            'content'          => $title,
            'question_type_id' => QuestionType::whereCode('SingleMultipleChoice')->firstOrFail()->id,
            'is_active'        => $inputs["is_active"]
        ]);

        return $subQuestion;
    }
}