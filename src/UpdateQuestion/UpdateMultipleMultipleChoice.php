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
    protected function updateChoices(Question $question, $choices):array {
        $answerIds = [];

        foreach ($choices as $choiceData) {
            if ($choiceData['type'] == '_db') {
                if ($choiceData['active']) {
                    $question->choices()->findOrFail($choiceData['id'])->update($choiceData);
                    if ($choiceData['is_corrected']) {
                        $answerIds[] = $choiceData['id'];
                    }
                } else {
                    $question->choices()->findOrFail($choiceData['id'])->delete();
                }
            } elseif ($choiceData['type'] == 'new') {
                $newChoice = $question->choices()->create($choiceData);
                if ($choiceData['is_corrected']) {
                    $answerIds[] = $newChoice->id;
                }
            }
        }
        return $answerIds;
    }

}