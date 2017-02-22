<?php
/**
 * Author: Xavier Au
 * Date: 8/2/2017
 * Time: 2:08 PM
 */

namespace Anacreation\Etvtest\QuestionType;


use Anacreation\Etvtest\Contracts\CreateQuestionInterface;
use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\QuestionType;
use Anacreation\Etvtest\Models\Test;

class InlineFillInBlanks implements CreateQuestionInterface
{

    /**
     * @param array     $inputs
     * @param \App\Test $test
     * @return Question
     */
    public function create(array $inputs, Test $test) {

        /** @var Question $question */
        $mainQuestion = $this->createMainQuestion($test, $inputs);

        $subQuestions = $this->createSubQuestions($mainQuestion, $inputs);

        $this->createChoicesAndAnswerForSubQuestions($subQuestions, $inputs);

        return $mainQuestion;
    }

    /**
     * @param \App\Test $test
     * @param array     $inputs
     * @return \App\Question
     */
    private function createMainQuestion(Test $test, array $inputs): Question {
        return $test->questions()->create($inputs);
    }

    /**
     * @param \App\Question $mainQuestion
     * @param array         $inputs
     * @return array
     */
    private function createSubQuestions(Question $mainQuestion, array $inputs) {
        $subQuestions = [];
        $questionTypeId = QuestionType::whereCode('SingleFillInBlanks')->firstOrFail()->id;
        foreach ($inputs['choices'] as $choice) {
            $subQuestion = $mainQuestion->subQuestions()->create([
                "prefix"          => "",
                "content"          => "",
                "question_type_id" => $questionTypeId,
                "is_active"        => true,
            ]);

            $subQuestions[] = $subQuestion;
        }

        return $subQuestions;
    }

    /**
     * @param array $subQuestions
     * @param array $inputs
     */
    private function createChoicesAndAnswerForSubQuestions(array $subQuestions, array $inputs) {
        foreach ($inputs['choices'] as $index => $choice) {
            $subQuestion = $subQuestions[$index];
            $newChoice = $subQuestion->choices()->create($choice);
            $subQuestion->answer()->create([
                "content" => $newChoice->id
            ]);
        }
    }
}