<?php
/**
 * Author: Xavier Au
 * Date: 19/2/2017
 * Time: 11:14 AM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Models\Question;

class UpdateMultipleMultipleChoice extends AbstractMultipleChoiceUpdateOperator
{
    /**
     * @param $choices
     */
    protected function updateChoices(Question $question, $choices) {
        foreach ($choices as $choiceData) {
            $question->choices()->findOrFail($choiceData['id'])->update($choiceData);
        }
    }

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param                                      $correctChoiceIds
     */
    protected function updateAnswer(Question $question, $correctChoiceIds) {
        $question->answer->update([
            'content' => $correctChoiceIds
        ]);
    }

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param                                      $content
     */
    protected function updateQuestion(Question $question, $content) {
        $question->update($content);
    }
}