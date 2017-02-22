<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 9:19 PM
 */

namespace Anacreation\Etvtest\Graders;


use Anacreation\Etvtest\Models\Question;
use Illuminate\Pagination\Paginator;

class MultipleMultipleChoiceGrader implements GraderInterface
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array         $answer
     * @return array
     */
    public function grade(Question $question, array $answer) {
        $correct = true;
        $answerObject =  $question->answer;

        if($answerObject->is_required_all){
            $result = array_diff($answer, $answerObject->content);
            if(count($result) > 0) $correct = false;;
            return [$correct, $answerObject->content];
        }else{
            $result = array_intersect($answerObject->content, $answer);
            if(count($result) <= 0) $correct = false;;
            return [$correct, $answerObject->content];
        }

    }
}