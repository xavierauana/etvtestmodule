<?php
/**
 * Author: Xavier Au
 * Date: 17/2/2017
 * Time: 4:35 PM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Models\Question;

class UpdateSingleMultipleChoice extends AbstractMultipleChoiceUpdateOperator
{
    protected function updateQuestion(Question $question, $content) {
        $question->update($content);
    }

    protected function updateChoices(Question $question, $choices): array {

        $answerId = [];

        foreach ($choices as $choiceData) {
            if ($choiceData['type'] == '_db') {
                if ($choiceData['active']) {
                    $question->choices()->findOrFail($choiceData['id'])->update($choiceData);
                    if ($choiceData['is_corrected']) {
                        $answerId[0] = $choiceData['id'];
                    }
                } else {
                    $question->choices()->findOrFail($choiceData['id'])->delete();
                }
            } elseif ($choiceData['type'] == 'new') {
                $newChoice = $question->choices()->create($choiceData);
                if ($choiceData['is_corrected']) {
                    $answerId[0] = $newChoice->id;
                }
            }
        }

        return $answerId;

    }
}