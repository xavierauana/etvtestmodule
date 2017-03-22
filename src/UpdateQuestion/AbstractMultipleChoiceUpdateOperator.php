<?php
/**
 * Author: Xavier Au
 * Date: 19/2/2017
 * Time: 11:28 AM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
use Anacreation\Etvtest\Models\Question;

abstract class AbstractMultipleChoiceUpdateOperator implements UpdateOperatorInterface
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    final public function update(Question $question, array $data): Question {
        list($content, $choices) = $this->parseData($data);

        $this->updateQuestion($question, $content);

        $correctChoiceIds = $this->updateChoices($question, $choices);

        $this->updateAnswer($question, $correctChoiceIds);

        return $question;
    }

    protected function parseData($data) {

        $content = UpdateMultipleChoiceHelpers::ParseDataForQuestionContent($data);

        return array($content, $data['choices']);
    }

    protected function updateQuestion(Question $question, $content) {
        $question->update($content);
    }

    protected function updateAnswer(Question $question, $correctChoiceIds) {
        $question->answer->update([
            'content' => $correctChoiceIds
        ]);
    }

    abstract protected function updateChoices(Question $question, $content): array;
}