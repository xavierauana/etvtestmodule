<?php
/**
 * Author: Xavier Au
 * Date: 24/1/2017
 * Time: 1:38 AM
 */

namespace Anacreation\Etvtest\QuestionType;


use Anacreation\Etvtest\Contracts\CreateQuestionInterface;
use Anacreation\Etvtest\Models\Test;

class MultipleMultipleChoice implements CreateQuestionInterface
{
    /**
     * @param array     $inputs
     * @param \Anacreation\Etvtest\Models\Test $test
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $inputs, Test $test) {

        $question = $test->questions()
            ->create($inputs);

        $correctedAnswers = [];

        foreach ($inputs['choices'] as $choice){
            $newChoice = $question->choices()->create($choice);
            if($choice['is_corrected']) $correctedAnswers[] = $newChoice->id;
        }

        if(count($correctedAnswers)){
            $question->answer()->create([
                'content'=>$correctedAnswers,
                'is_ordered'=>false,
                'is_required_all'=>$inputs['is_required_all']
            ]);
        }

        return $question;
    }
}