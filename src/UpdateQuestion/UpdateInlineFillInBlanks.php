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
     * @var Question $question
     */
    private $question;

    /**
     * UpdateInlineFillInBlanks constructor.
     * @param Question $question
     */
    public function __construct(Question $question) {
        $this->question = $question;
    }

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    public function update(Question $question, array $data): Question {

        $this->updateMainQuestion($data);

        $this->updateSubQuestions($data);

        return $this->question;
    }

    private function updateMainQuestion($data): void {
        $this->question->update($data);
    }

    /**
     * @param $question
     * @param $data
     */
    private function updateSubQuestions($data) {
        foreach ($data['sub_questions'] as $sub_question) {
            if ($this->isExistingSubQuestion($sub_question)) {
                $this->updateExistingSubQuestion($sub_question);
            } else {
                $this->createNewSubQuestion($sub_question);
            }
        }
    }

    /**
     * @param $sub_question
     * @return mixed
     */
    private function isExistingSubQuestion($sub_question): bool {
        return !!$sub_question['id'];
    }

    /**
     * @param $sub_question_data
     */
    private function updateExistingSubQuestion($sub_question_data) {
        /* @var Question $subQuestion */
        $subQuestion = $this->question->subQuestions()->findOrFail($sub_question_data['id']);
        if (!$sub_question_data["choices"][0]['active']) {
            // Delete exsiting sub_question
            $subQuestion->delete();
        } else {
            /* @var \Anacreation\Etvtest\Models\Choice $theChoice */
            $theChoice = $subQuestion->choices()->findOrFail($sub_question_data['choices'][0]['id']);
            $theChoice->update([
                'content' => $sub_question_data['choices'][0]['content']
            ]);
        }
    }

    /**
     * @param $sub_question_data
     */
    private function createNewSubQuestion($sub_question_data) {
        // create new sub_question
        /* @var Question $new_sub_question */
        $new_sub_question = $this->question->subQuestions()->create([
            'content'          => "",
            'prefix'           => "",
            'is_active'        => true,
            'is_required_all'  => false,
            'page_number'      => 1,
            'question_type_id' => 4
        ]);
        $choice = $new_sub_question->choices()->create([
            'content' => $sub_question_data['choices'][0]['content']
        ]);
        $new_sub_question->answer()->create([
            'content' => $choice->id
        ]);
    }
}