<?php
/**
 * Author: Xavier Au
 * Date: 19/2/2017
 * Time: 5:40 PM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
use Anacreation\Etvtest\Models\Question;

class UpdateInlineMultipleChoice implements UpdateOperatorInterface
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    public function update(Question $question, array $data): Question {
        // TODO: Implement update() method.
        $question = $this->updateQuestion($data);

        $this->updateSubQuestion($question, $data);

        return $question;

    }

    private function updateSubQuestion(Question $question, $data): void {

        foreach ($data['sub_questions'] as $sub_question) {

            if ($this->hasQuestionId($sub_question)) {

                $this->updateExistingSubQuestion($question, $sub_question);

            } else {

                $newSubQuestion = $this->createSubQuestion($question, $sub_question);
                $this->updateSubQuestionChoices($newSubQuestion, $sub_question);
            }

        }
    }

    /**
     * @param array $data
     */
    private function updateQuestion(array $data): Question {
        $question = Question::findOrFail($data['id']);

        $question->update([
            'prefix'      => $data['prefix'],
            'content'     => $data['content'],
            'is_active'   => $data['is_active'],
            'page_number' => $data['page_number'],
        ]);

        return $question;
    }

    private function createSubQuestion(Question $question, $data): Question {
        /* @var Question $newSubQuestion */
        $newSubQuestion = $question->subQuestions()->create($data);

        return $newSubQuestion;
    }

    private function updateSubQuestionChoices($newSubQuestion, $sub_question) {
        foreach ($sub_question['choices'] as $choiceData) {
            $this->createChoice($newSubQuestion, $choiceData);
        }
    }

    /**
     * @param $subQuestion
     * @param $choiceData
     */
    private function createChoice(Question $subQuestion, array $choiceData): void {
        $subQuestion->choices()->create($choiceData);
        if ($choiceData['is_corrected']) {
            $subQuestion->answer()->create([
                'content' => $choiceData['id']
            ]);
        }
    }

    /**
     * @param $sub_question
     * @return bool
     */
    private function hasQuestionId($sub_question): bool {
        return !!$sub_question['id'];
    }

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param                                      $sub_question
     */
    private function updateExistingSubQuestion(Question $question, $sub_question): void {

        $subQuestion = $question->subQuestions()->findOrFail($sub_question['id']);

        foreach ($sub_question['choices'] as $choiceData) {
            if ($this->isActiveChoice($choiceData)) {
                $this->updateExistingChoice($subQuestion, $choiceData);
            } elseif ($this->needsToDelete($choiceData)) {
                $this->deleteChoice($subQuestion, $choiceData);
            } else {
                $this->createChoice($subQuestion, $choiceData);
            }
        }
    }

    private function isActiveChoice($choiceData): bool {
        return $choiceData['id'] && $choiceData['active'];
    }

    /**
     * @param $subQuestion
     * @param $choiceData
     */
    private function updateExistingChoice($subQuestion, $choiceData): void {
        $subQuestion->choices()->findOrFail($choiceData['id'])->update($choiceData);
        if ($choiceData['is_corrected']) {
            $subQuestion->answer->update([
                'content' => $choiceData['id']
            ]);
        }
    }

    private function needsToDelete($choiceData): bool {
        return $choiceData['id'] && !$choiceData['active'];
    }

    /**
     * @param $subQuestion
     * @param $choiceData
     */
    private function deleteChoice($subQuestion, $choiceData): void {
        $subQuestion->choices()->findOrFail($choiceData['id'])->delete();
    }
}