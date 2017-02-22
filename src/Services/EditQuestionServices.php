<?php
/**
 * Author: Xavier Au
 * Date: 17/2/2017
 * Time: 1:31 PM
 */

namespace Anacreation\Etvtest\Services;


use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\UpdateQuestion\UpdateOperatorFactory;

class EditQuestionServices
{

    public function getQuestionWithAnswerAndChoicesById($id): Question {
        /** @var Question $question */
        $question = Question::with([
            'choices',
            'answer',
            'subquestions' => function ($query) {
                $query->with("choices", 'answer');
            }
        ])->findOrFail($id);

        return $question;
    }

    public function updateQuestionById(int $id, array $data): Question {

        $question = Question::findOrFail($id);

        $operator = UpdateOperatorFactory::make($question);

        $updatedQuestion = $operator->update($question, $data);

        return $updatedQuestion;

    }
}