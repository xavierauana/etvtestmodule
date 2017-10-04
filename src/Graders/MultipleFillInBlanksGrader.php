<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 9:30 PM
 */

namespace Anacreation\Etvtest\Graders;


use Anacreation\Etvtest\Models\Choice;
use Anacreation\Etvtest\Models\Question;

class MultipleFillInBlanksGrader implements GraderInterface
{
    use GraderTrait;

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $answer
     * @return array
     */
    public function grade(Question $question, array $answers) {

        $answerStringArray = [];
        $answerObject = $question->answer;
        $answers = $this->cleanUserInputAnswerArray($answers);

        foreach ($answerObject->content as $choiceId) {
            $answerStringArray[] = Choice::findOrFail($choiceId)->content;
        }

        if ($this->isEmptyAnswer($answers)) {
            return [false, $answerStringArray];
        }

        return [
            $this->checkAnswer($answers, $answerObject, $answerStringArray),
            $answerStringArray
        ];
    }

    private function cleanUserInputAnswerArray(array $answers): array {
        return array_map(function ($item) {
            return trim($item);
        }, $answers);
    }

    /**
     * @param array $answers
     * @param       $answerObject
     * @param       $answerStringArray
     * @return array
     */
    private function checkAnswer(
        array $answers, $answerObject, $answerStringArray
    ): bool {

        if ($this->requiredAllAndInOrdered($answerObject)) {
            $correct = true;
            foreach ($answerStringArray as $index => $answerString) {
                if (!isset($answers[$index]) or $this->isAnswerCorrect($answers[$index],
                        $answerString)) {
                    $correct = false;
                }
            }

            return $correct;
        }

        if ($this->requiredAllAndNotInOrder($answerObject)) {
            $result = array_diff($answerStringArray, $answers);

            return $result == 0;
        }

        if ($this->notRequiredAllAndInOrdered($answerObject)) {
            $correct = true;
            foreach ($answers as $index => $answer) {
                if ($this->isAnswerCorrect($answerStringArray[$index],
                    $answer)) {
                    $correct = false;
                }
            }

            return $correct;
        }

        if ($this->notRequiredAllAndNotInOrdered($answerObject)) {
            $result = array_intersect($answerStringArray, $answers);

            return $result > 0;
        }
    }

    /**
     * @param $answerObject
     * @return bool
     */
    private function requiredAllAndInOrdered($answerObject): bool {
        return $answerObject->is_required_all and $answerObject->is_ordered;
    }

    /**
     * @param $answerObject
     * @return bool
     */
    private function requiredAllAndNotInOrder($answerObject): bool {
        return $answerObject->is_required_all and !$answerObject->is_ordered;
    }

    /**
     * @param $answerObject
     * @return bool
     */
    private function notRequiredAllAndInOrdered($answerObject): bool {
        return !$answerObject->is_required_all and $answerObject->is_ordered;
    }

    /**
     * @param $answerObject
     * @return bool
     */
    private function notRequiredAllAndNotInOrdered($answerObject): bool {
        return !$answerObject->is_required_all and !$answerObject->is_ordered;
    }

    /**
     * @param $answerStringArray
     * @param $index
     * @param $answer
     * @return bool
     */
    private function isAnswerCorrect(string $submitted, string $correctedAnswer
    ): bool {
        return trim($submitted) != trim($correctedAnswer);
    }
}