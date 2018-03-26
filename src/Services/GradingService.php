<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 10:21 PM
 */

namespace Anacreation\Etvtest\Services;


use Anacreation\Etvtest\Graders\GraderManger;
use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\Test;

class GradingService
{
    public $result = [];
    public $summary = ['correct' => 0];

    public function grade(Test $test, array $answers, array $questionIds = []) {

        $questions = count($questionIds) ? $test->questions()->whereIsActive(1)
                                                ->whereIn('questions.id',
                                                    $questionIds)
                                                ->get() : $test->questions()
                                                               ->whereIsActive(1)
                                                               ->get();

        foreach ($questions as $question) {
            $this->_grade($question, $answers);
        }
    }

    private function _grade(Question $question, array $answers): void {
        if ($question->subQuestions->count() > 0) {
            foreach ($question->subQuestions as $subQuestion) {
                $this->_grade($subQuestion, $answers);
            }
        } else {
            $answerArray = $this->getTheAnswerArray($question, $answers);

            list($is_correct, $correct_answer) = GraderManger::grade($question,
                $answerArray);

            $this->constructData($is_correct, $question, $answerArray,
                $correct_answer);
        }

    }

    /**
     * @param $is_correct
     * @param $question
     * @param $answerArray
     * @param $correct_answer
     */
    private function constructData(
        $is_correct, $question, $answerArray, $correct_answer
    ) {
        $this->summary['correct'] = $is_correct ? $this->summary['correct'] + 1 : $this->summary['correct'];
        $this->result[] = [
            'id'             => $question->id,
            'input'          => $answerArray,
            'is_correct'     => $is_correct,
            'correct_answer' => $correct_answer,
        ];
    }

    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $answers
     * @return array|mixed|answer
     */
    private function getTheAnswerArray(Question $question, array $answers) {

        $answerArray = array_filter($answers,
            function ($answer) use ($question) {
                return $answer['id'] == $question->id;
            });
        if (count($answerArray) > 0) {
            $answerArray = array_shift($answerArray);
            if (isset($answerArray['answer'])) {
                $answerArray = is_array($answerArray['answer']) ? $answerArray['answer'] : [$answerArray['answer']];
            } else {
                $answerArray = [];
            }

        }

        return $answerArray;
    }
}