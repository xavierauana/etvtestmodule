<?php
/**
 * Author: Xavier Au
 * Date: 20/2/2017
 * Time: 5:01 PM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
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
            "order"         => $data['order'],
            "is_active"     => $data['is_active'],
            "is_fractional" => $data['is_fractional'],
        ];

        $question->update($questionData);

        $choiceData = $data['choices'];

        $answerIds = [];

        foreach ($choiceData as $choicesDatum) {
            $choice = $question->choices()->findOrFail($choicesDatum['id']);
            $choice->update([
                'content' => $choicesDatum['content']
            ]);
            $answerIds[] = $choicesDatum['id'];
        }

        $question->answer->update([
            'content' => $answerIds
        ]);

        return $question;
    }
}