<?php
/**
 * Author: Xavier Au
 * Date: 3/2/2017
 * Time: 9:59 PM
 */

namespace Anacreation\Etvtest\QuestionType;


use Anacreation\Etvtest\Contracts\CreateQuestionInterface;
use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\QuestionType;
use Anacreation\Etvtest\Models\Test;

class Comprehension implements CreateQuestionInterface
{

    /**
     * @param array     $inputs
     * @param \App\Test $test
     * @return Question
     */
    public function create(array $inputs, Test $test) {
        /** @var Question $mainQuestion */
        $mainQuestion = $test->questions()->create($inputs);

        foreach ($inputs['sub_questions'] as $question) {
            $this->createSubQuestion($mainQuestion, $question);
        }

        return $mainQuestion;
    }

    private function createSubQuestion($mainQuestion, $question) {
        $subQuestion = $mainQuestion->subQuestions()->create([
            'content'          => $question['content'],
            'question_type_id' => QuestionType::whereCode('SingleFillInBlanks')->firstOrFail()->id,
            'is_active'        => true
        ]);
        $choice = $subQuestion->choices()->create([
            'content' => $question['answer']
        ]);
        $subQuestion->answer()->create([
            'content' => [$choice->id]
        ]);

    }
}