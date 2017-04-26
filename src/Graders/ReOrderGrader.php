<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 9:39 PM
 */

namespace Anacreation\Etvtest\Graders;


use Anacreation\Etvtest\Models\Question;

class ReOrderGrader implements GraderInterface
{
    use GraderTrait;

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $answer
     * @return array
     */
    public function grade(Question $question, array $answers) {
        $correct = true;
        $answerObject = $question->answer;

        if ($this->isEmptyAnswer($answers)) {
            return [false, $answerObject->content];
        }


        if ($answerObject == null) {
            throw new \Exception("no answer!");
        }

        foreach ($answerObject->content as $index => $answer) {
            if (!isset($answers[$index]) or $answer != $answers[$index]) {
                $correct = false;
            }
        }

        return [$correct, $answerObject->content];

    }
}