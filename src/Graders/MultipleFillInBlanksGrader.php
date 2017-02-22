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

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array         $answer
     * @return array
     */
    public function grade(Question $question, array $answers) {

        $answerObject =  $question->answer;
        $answerStringArray = [];

        foreach ($answerObject->content as $choiceId){
            $answerStringArray[] = Choice::findOrFail($choiceId)->content;
        }

        if($answerObject->is_required_all and $answerObject->is_ordered){
            $correct = true;
            foreach ($answerStringArray as $index=>$answerString){
                if($answers[$index] != $answerString) $correct = false;
            }
            return [$correct, $answerStringArray];
        }

        if($answerObject->is_required_all and !$answerObject->is_ordered){
            $result = array_diff($answerStringArray, $answers);
            return [$result == 0, $answerStringArray];
        }

        if(!$answerObject->is_required_all and $answerObject->is_ordered){
            $correct = true;
            foreach ($answers as $index=>$answer){
                if($answerStringArray[$index] != $answer) $correct = false;
            }
            return [$correct, $answerStringArray];
        }

        if(!$answerObject->is_required_all and !$answerObject->is_ordered){
            $result = array_intersect($answerStringArray, $answers);
            return [$result > 0, $answerStringArray];
        }

    }
}