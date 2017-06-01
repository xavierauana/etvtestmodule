<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 9:24 PM
 */

namespace Anacreation\Etvtest\Graders;


use Anacreation\Etvtest\Models\Choice;
use Anacreation\Etvtest\Models\Question;

class SingleFillInBlanksGrader implements GraderInterface
{
    use GraderTrait;

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $answer
     * @return array
     */
    public function grade(Question $question, array $answer) {
        $correct = true;
        $answerObject = $question->answer;
        $answerStringArray = [];

        $answer = $this->cleanUserInputAnswerArray($answer);

        foreach ($answerObject->content as $choiceId) {
            $answerStringArray[] = Choice::findOrFail($choiceId)->content;
        }

        if ($this->isEmptyAnswer($answer)) {
            return [false, $answerStringArray];
        }

        $result = array_intersect($answerStringArray, $answer);
        if (count($result) <= 0) {
            $correct = false;
        };

        return [$correct, $answerStringArray];
    }

    private function cleanUserInputAnswerArray(array $answers): array {
        return array_map(function ($item) {
            return trim($item);
        }, $answers);
    }
}