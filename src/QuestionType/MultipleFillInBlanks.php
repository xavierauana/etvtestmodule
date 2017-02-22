<?php
/**
 * Author: Xavier Au
 * Date: 25/1/2017
 * Time: 8:31 PM
 */

namespace Anacreation\Etvtest\QuestionType;


use Anacreation\Etvtest\Contracts\CreateQuestionInterface;
use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\Test;

class MultipleFillInBlanks implements CreateQuestionInterface
{

    /**
     * @param array     $inputs
     * @param \Anacreation\Etvtest\Models\Test $test
     * @return Question
     */
    public function create(array $inputs, Test $test) {

        /** @var Question $question */
        $question = $test->questions()
            ->create($inputs);

        $answerIds = [];
        foreach ($inputs['choices'] as $choice){
            $newChoice = $question->choices()->create($choice);
            $answerIds[] = $newChoice->id;
        }
        $question->answer()->create([
            'content'=>$answerIds,
            'is_ordered'=>$inputs['is_ordered'],
            'is_required_all'=>true
        ]);
        return $question;
    }
}