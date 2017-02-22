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

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array         $answer
     * @return array
     */
    public function grade(Question $question, array $answer) {
        $correct = true;
        $answerObject =  $question->answer;
        $answerStringArray = [];

        foreach ($answerObject->content as $choiceId){
            $answerStringArray[] = Choice::findOrFail($choiceId)->content;
        }

        $result = array_intersect($answerStringArray, $answer);
        if(count($result) <= 0) $correct = false;;
        return [$correct, $answerStringArray];

    }
}