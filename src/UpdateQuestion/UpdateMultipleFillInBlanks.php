<?php
/**
 * Author: Xavier Au
 * Date: 20/2/2017
 * Time: 5:01 PM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
use Anacreation\Etvtest\Models\Choice;
use Anacreation\Etvtest\Models\Question;

class UpdateMultipleFillInBlanks implements UpdateOperatorInterface
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    public function update(Question $question, array $data): Question {
        // TODO: Implement update() method.
        $questionData = [
            "content"       => $data['content'],
            "prefix"        => $data['prefix'],
            "page_number"   => $data['page_number'],
            "is_active"     => $data['is_active'],
            "is_ordered"    => $data['is_ordered'],
            "is_fractional" => $data['is_fractional'],
        ];

        $question->update($questionData);

        $answerIds = $this->updateChoices($question, $data);

        $this->updateAnswer($question, $answerIds, $questionData);

        return $question;
    }

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return array
     */
    private function updateChoices(Question $question, array $data): array {
        $choiceData = $data['choices'];

        $answerIds = [];

        foreach ($choiceData as $choicesDatum) {
            /** @var Choice $choice */
            $choice = $question->choices()->findOrFail($choicesDatum['id']);
            $choice->update([
                'content' => $choicesDatum['content']
            ]);
            $answerIds[] = $choicesDatum['id'];
        }

        return $answerIds;
    }

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param                                      $answerIds
     * @param                                      $questionData
     */
    private function updateAnswer(Question $question, $answerIds, $questionData) {
        $question->answer->content = $answerIds;
        $question->answer->is_ordered = $questionData['is_ordered'];
        $question->answer->save();
    }
}