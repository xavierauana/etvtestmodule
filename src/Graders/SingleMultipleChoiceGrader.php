<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 9:02 PM
 */

namespace Anacreation\Etvtest\Graders;


use Anacreation\Etvtest\Models\Question;

class SingleMultipleChoiceGrader implements GraderInterface
{
    use GraderTrait;
    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array         $answer
     * @return array
     */
    public function grade(Question $question, array $answer) {
        $correct = true;
        $answerObject =  $question->answer;
        if($this->isEmptyAnswer($answer)) return [false, $answerObject->content];
        $result = array_diff($answerObject->content, $answer);
        if(count($result) > 0) $correct = false;;
        return [$correct, $answerObject->content];
    }
}