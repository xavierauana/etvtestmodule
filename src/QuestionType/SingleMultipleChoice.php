<?php
/**
 * Author: Xavier Au
 * Date: 20/1/2017
 * Time: 3:54 AM
 */

namespace Anacreation\Etvtest\QuestionType;


use Anacreation\Etvtest\Contracts\CreateQuestionInterface;
use Anacreation\Etvtest\Models\Test;

class SingleMultipleChoice implements CreateQuestionInterface
{


    /**
     * @param array     $inputs
     * @param \Anacreation\Etvtest\Models\Test $test
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $inputs, Test $test) {

        $question = $test->questions()
            ->create($inputs);

        foreach ($inputs['choices'] as $choice){
            $newChoice = $question->choices()->create($choice);
            if($choice['is_corrected']) $question->answer()->create([
               'content'=>$newChoice->id,
               'is_ordered'=>false,
               'is_required_all'=>false
            ]);
        }
        return $question;
    }
}