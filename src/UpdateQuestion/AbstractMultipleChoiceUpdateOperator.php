<?php
/**
 * Author: Xavier Au
 * Date: 19/2/2017
 * Time: 11:28 AM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


use Anacreation\Etvtest\Contracts\UpdateOperatorInterface;
use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Services\QuestionTypeServices;

abstract class AbstractMultipleChoiceUpdateOperator implements UpdateOperatorInterface
{

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    final public function update(Question $question, array $data): Question {
        list($content, $correctChoiceIds, $choices) = $this->parseData($data);

        $this->updateQuestion($question, $content);

        $this->updateChoices($question, $choices);

        $this->updateAnswer($question, $correctChoiceIds);

        return $question;
    }

    protected function parseData($data) {
        $content = UpdateMultipleChoiceHelpers::ParseDataForQuestionContent($data);

        list($correctChoiceIds, $choices) = UpdateMultipleChoiceHelpers::ParseDataForAnswersAndChoices($data);

        if (count($correctChoiceIds) == 1) {
            $content['question_type_id'] = (new QuestionTypeServices())->getQuestionTypeByCode("SingleMultipleChoice")->id;

        } elseif (count($correctChoiceIds) > 1) {

            $content['question_type_id'] = (new QuestionTypeServices())->getQuestionTypeByCode("MultipleMultipleChoice")->id;
        } else {
            throw new \Exception("Invalid answer setting for the question!", 500);
        }

        return array($content, $correctChoiceIds, $choices);
    }

    abstract protected function updateQuestion(Question $question, $content);

    abstract protected function updateChoices(Question $question, $content);

    abstract protected function updateAnswer(Question $question, $content);
}