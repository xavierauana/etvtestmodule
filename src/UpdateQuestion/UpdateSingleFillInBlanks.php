<?php
/**
 * Author: Xavier Au
 * Date: 20/2/2017
 * Time: 4:49 PM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
use Anacreation\Etvtest\Models\Question;

class UpdateSingleFillInBlanks implements UpdateOperatorInterface
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    public function update(Question $question, array $data): Question {
        $questionData = [
            "content"     => $data['content'],
            "prefix"      => $data['prefix'],
            "is_active"   => $data['is_active'],
            "page_number" => $data['page_number'],
        ];

        if (isset($data['order'])) {
            $questionData['order'] = $data['order'];
        }

        $question->update($questionData);

        $choiceData = $data['choices'][0];

        $choice = $question->choices()->findOrFail($choiceData['id']);

        $choice->update([
            'content' => $choiceData['content']
        ]);

        return $question;
    }
}