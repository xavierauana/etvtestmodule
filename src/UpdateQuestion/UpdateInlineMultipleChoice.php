<?php
/**
 * Author: Xavier Au
 * Date: 19/2/2017
 * Time: 5:40 PM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
use Anacreation\Etvtest\Models\Answer;
use Anacreation\Etvtest\Models\Choice;
use Anacreation\Etvtest\Models\Question;

/**
 * Class UpdateInlineMultipleChoice
 * @package Anacreation\Etvtest\UpdateQuestion
 */
class UpdateInlineMultipleChoice implements UpdateOperatorInterface
{
    /* @var Question $question */
    private $question;
    private $subQuestionIds = [];

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    public function update(Question $question, array $data): Question {

        $this->updateQuestion($data);

        $this->updateSubQuestion($data);

        $this->deleteSubQuestions();

        return $question;

    }

    /**
     * @param array $data
     */
    private function updateQuestion(array $data): void {

        $this->question = Question::findOrFail($data['id']);

        $this->question->update([
            'prefix'      => $data['prefix'],
            'content'     => $data['content'],
            'is_active'   => $data['is_active'],
            'page_number' => $data['page_number'],
        ]);
    }

    // Sub Questions

    private function updateSubQuestion($data): void {


        foreach ($data['sub_questions'] as $sub_question_data) {

            if ($this->isExistingSubQuestion($sub_question_data)) {
                $this->updateExistingSubQuestion($sub_question_data);
            } else {
                $this->createSubQuestion($sub_question_data);
            }

        }
    }

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param                                      $sub_question
     */
    private function updateExistingSubQuestion($sub_question): void {

        $subQuestion = $this->question->subQuestions()->findOrFail($sub_question['id']);

        $correctedIds = $this->updateSubQuestionChoice($sub_question['choices'], $subQuestion);

        $this->updateQuestionAnswer($subQuestion, $correctedIds);

        $this->subQuestionIds[] = $subQuestion->id;
    }

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param                                      $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    private function createSubQuestion($data): Question {

        /** @var Question $newSubQuestion */
        $newSubQuestion = $this->question->subQuestions()->create($data);

        $correctedIds = $this->updateSubQuestionChoice($data['choices'], $newSubQuestion);

        $this->updateQuestionAnswer($newSubQuestion, $correctedIds);

        return $newSubQuestion;
    }

    private function deleteSubQuestions(): void {
        $questions = $this->question->subQuestions()->whereNotIn('id', $this->subQuestionIds)->get();

        /** @var Question $question */
        foreach ($questions as $question) {
            $question->delete();
        }
    }

    /**
     * @param $choiceData
     * @param $subQuestion
     * @param $correctedIds
     * @return array
     */

    // Choices

    private function updateSubQuestionChoice($choicesData, $subQuestion): array {

        $correctedIds = [];

        foreach ($choicesData as $choiceData) {

            if ($this->isActiveExistingChoice($choiceData)) {
                $this->updateExistingChoice($subQuestion, $choiceData);
            } elseif ($this->needsToDelete($choiceData)) {
                $this->deleteChoice($subQuestion, $choiceData);
            } elseif ($this->needsToCreateChoice($choiceData)) {
                $choiceData['id'] = $this->createChoice($subQuestion, $choiceData)->id;
            }

            if ($choiceData['active'] and $choiceData['is_corrected']) {
                $correctedIds[] = $choiceData['id'];
            }
        }


        return $correctedIds;
    }

    /**
     * @param $subQuestion
     * @param $choiceData
     */
    private function createChoice(Question $subQuestion, array $choiceData): Choice {

        /** @var Choice $newChoice */
        $newChoice = $subQuestion->choices()->create($choiceData);

        return $newChoice;
    }

    /**
     * @param $subQuestion
     * @param $choiceData
     */
    private function updateExistingChoice($subQuestion, $choiceData): void {
        $subQuestion->choices()->findOrFail($choiceData['id'])->update($choiceData);
    }

    /**
     * @param $subQuestion
     * @param $choiceData
     */
    private function deleteChoice($subQuestion, $choiceData): void {
        $subQuestion->choices()->findOrFail($choiceData['id'])->delete();
    }

    // Answer

    private function updateQuestionAnswer(Question $question, $correctedIds): Answer {

        $answer = $question->answer;

        if ($answer) {
            $answer->update([
                'content' => $correctedIds
            ]);
        } else {
            $answer = $question->answer()->create([
                'content' => $correctedIds
            ]);
        }

        return $answer;
    }


    // Utils

    /**
     * @param $sub_question
     * @return bool
     */
    private function isExistingSubQuestion($sub_question): bool {
        return !!$sub_question['id'];
    }

    private function isActiveExistingChoice($choiceData): bool {
        return $choiceData['id'] && $choiceData['active'];
    }

    private function needsToDelete($choiceData): bool {
        return $choiceData['id'] && !$choiceData['active'];
    }

    private function needsToCreateChoice($choiceData): bool {
        return !$choiceData['id'] and $choiceData['active'];
    }

}