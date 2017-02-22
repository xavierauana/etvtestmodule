<?php
/**
 * Author: Xavier Au
 * Date: 17/2/2017
 * Time: 4:35 PM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Models\Choice;
use Anacreation\Etvtest\Models\Question;

class UpdateSingleMultipleChoice extends AbstractMultipleChoiceUpdateOperator
{
    protected function updateQuestion(Question $question, $content) {
        $question->update($content);
    }

    protected function updateChoices(Question $question, $choices) {
        foreach ($choices as $choiceData) {
            $question->choices()->findOrFail($choiceData['id'])->update($choiceData);
        }

    }

    protected function updateAnswer(Question $question, $correctChoiceId) {
        $question->answer->update([
            'content' => $correctChoiceId
        ]);
    }
}