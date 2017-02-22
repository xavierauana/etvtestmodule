<?php
/**
 * Author: Xavier Au
 * Date: 31/1/2017
 * Time: 4:58 PM
 */

namespace Anacreation\Etvtest\QuestionType;


use Anacreation\Etvtest\Contracts\CreateQuestionInterface;
use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\Test;

class ReOrder implements CreateQuestionInterface
{

    /**
     * @param array     $inputs
     * @param \Anacreation\Etvtest\Models\Test $test
     * @return Question
     */
    public function create(array $inputs, Test $test) {

        /** @var Question $question */
        $question = $test->questions()->create($inputs);


        $sequenceArray = array_map(function ($item) {
            return trim($item);
        }, explode(",", $inputs['sequence']));

        $choiceIds = [];

        foreach ($inputs['choices'] as $choice) {
            $newChoice = $question->choices()->create($choice);
            $choiceIds[] = $newChoice->id;
        }

        $correctedSequence = [];
        foreach ($sequenceArray as $index) {
            $correctedSequence[] = $choiceIds[$index - 1];
        }

        $question->answer()->create([
            'content'         => $correctedSequence,
            'is_ordered'      => true,
            'is_required_all' => true
        ]);

        return $question;
    }
}