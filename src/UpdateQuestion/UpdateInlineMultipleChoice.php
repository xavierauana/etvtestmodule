<?php
/**
 * Author: Xavier Au
 * Date: 19/2/2017
 * Time: 5:40 PM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
use Anacreation\Etvtest\Models\Question;

class UpdateInlineMultipleChoice implements UpdateOperatorInterface
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    public function update(Question $question, array $data): Question {
        // TODO: Implement update() method.
        $question = $this->updateQuestion($data);

        $this->updateSubQuestion($question, $data);

        return $question;

    }

    private function updateSubQuestion(Question $question, $data): void {

        foreach ($data['sub_questions'] as $sub_question) {
            $subQuestion = $question->subQuestions()->findOrFail($sub_question['id']);

            foreach ($sub_question['choices'] as $choiceData) {
                $subQuestion->choices()->findOrFail($choiceData['id'])->update([
                    'content' => $choiceData['content']
                ]);
                if($choiceData['is_corrected'])
                    $subQuestion->answer->update([
                        'content'=>$choiceData['id']
                    ]);
            }
        }
    }

    /**
     * @param array $data
     */
    private function updateQuestion(array $data): Question {
        $question = Question::findOrFail($data['id']);

        $question->update([
            'prefix'  => $data['prefix'],
            'content' => $data['content'],
            'is_active' => $data['is_active'],
            'page_number' => $data['page_number'],
        ]);

        return $question;
    }
}