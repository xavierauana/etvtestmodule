<?php
/**
 * Author: Xavier Au
 * Date: 24/3/2017
 * Time: 12:40 PM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
use Anacreation\Etvtest\Models\Question;

class UpdateInlineFillInBlanks implements UpdateOperatorInterface

{

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    public function update(Question $question, array $data): Question {
        $question = $this->updateMainQuestion($question, $data);
        $this->updateSubQuestions($question, $data);

        return $question;
    }

    private function updateMainQuestion(Question $question, $data) {
        $question->update($data);

        return $question;
    }

    /**
     * @param $question
     * @param $data
     */
    private function updateSubQuestions(Question $question, $data) {
        foreach ($data['sub_questions'] as $sub_question) {
            if ($sub_question['id']) {
                // Update exsiting sub_question
                /* @var Question $subQuestion */
                $subQuestion = $question->subQuestions()->findOrFail($sub_question['id']);
                if (!$sub_question["choices"][0]['active']) {
                    // Delete exsiting sub_question
                    $subQuestion->delete();
                } else {
                    /* @var \Anacreation\Etvtest\Models\Choice $theChoice */
                    $theChoice = $subQuestion->choices()->findOrFail($sub_question['choices'][0]['id']);
                    $theChoice->update([
                        'content' => $sub_question['choices'][0]['content']
                    ]);
                }
            } else {
                // create new sub_question
                /* @var Question $newSubquestion */
                $newSubquestion = $question->subQuestions()->create([
                    'content'          => "",
                    'prefix'           => "",
                    'is_active'        => true,
                    'is_required_all'  => false,
                    'page_number'      => 1,
                    'question_type_id' => 4
                ]);
                $choice = $newSubquestion->choices()->create([
                    'content' => $sub_question['choices'][0]['content']
                ]);
                $newSubquestion->answer()->create([
                    'content' => $choice->id
                ]);
            }
        }
    }
}