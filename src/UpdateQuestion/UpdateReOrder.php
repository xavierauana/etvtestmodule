<?php
/**
 * Author: Xavier Au
 * Date: 17/3/2017
 * Time: 5:49 PM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
use Anacreation\Etvtest\Models\Question;

class UpdateReOrder implements UpdateOperatorInterface
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    public function update(Question $question, array $data): Question {

        $question->update($data);

        $choiceIds = $this->updateChoices($question, $data['choices']);

        $this->updateAnswer($question, $data['answer'], $choiceIds);

        return $question;
    }

    private function updateChoices(Question $question, $choicesArray): array {


        $choiceIds = [];

        foreach ($choicesArray as $choiceData) {
            if ($choiceData['type'] == '_db') {
                if ($choiceData['active']) {
                    $question->choices()->findOrFail($choiceData['id'])->update($choiceData);
                    $choiceIds[] = $choiceData['id'];
                } else {
                    $question->choices()->findOrFail($choiceData['id'])->delete();
                }
            } elseif ($choiceData['type'] == 'new') {
                $newChoice = $question->choices()->create($choiceData);
                $choiceIds[] = $newChoice->id;
            }
        }

        return $choiceIds;
    }

    private function updateAnswer(Question $question, array $answer, array $choiceIds): void {

        $sequenceIds = [];
        foreach ($answer as $sequence ) {
            $sequenceIds[] = $choiceIds[$sequence - 1];
        }

        if ($question->answer) {
            $question->answer->content = $sequenceIds;
            $question->answer->save();
        } else {
            $question->answer()->create([
                'content' => $sequenceIds
            ]);
        }

    }

}