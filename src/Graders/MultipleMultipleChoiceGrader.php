<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 9:19 PM
 */

namespace Anacreation\Etvtest\Graders;


use Anacreation\Etvtest\Models\Question;

class MultipleMultipleChoiceGrader implements GraderInterface
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

        if ($this->isEmptyAnswer($answer)) {
            return [false, $answerObject->content];
        }

        if ($answerObject->is_required_all) {
            if (count(array_diff($answerObject->content, $answer)) > 0 || count(array_diff($answer,
                    $answerObject->content)) > 0
            ) {
                $correct = false;
            };

            return [$correct, $answerObject->content];
        } else {
            $result = array_intersect($answerObject->content, $answer);
            if (count($result) <= 0) {
                $correct = false;
            };

            return [$correct, $answerObject->content];
        }

    }
}