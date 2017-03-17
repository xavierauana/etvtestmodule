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

        $this->updateChoices($question, $data['choices']);

        $this->updateAnswer($question, $data['answer']);

        return $question;
    }

    private function updateChoices(Question $question, $choicesArray): void {
        foreach ($choicesArray as $choice) {
            $theChoice = $question->find($choice['id']);
            if ($theChoice) {
                $theChoice->update($choice);
            }
        }
    }

    private function updateAnswer(Question $question, array $answer): void {
        if ($question->answer) {
            $question->answer->content = $answer;
            $question->answer->save();
        } else {
            $question->answer()->create([
                'content' => $answer
            ]);
        }

    }


}