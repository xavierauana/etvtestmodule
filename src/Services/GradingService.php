<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 10:21 PM
 */

namespace Anacreation\Etvtest\Services;


use Anacreation\Etvtest\Graders\GraderManger;
use Anacreation\Etvtest\Models\Question;

class GradingService
{
    public $result = [];
    public $summary = ['correct' => 0];

    public function grade(array $answers) {

        foreach ($answers as $answer) {

            $question = Question::findOrFail($answer['id']);

            $answerArray = is_array($answer['answer']) ? $answer['answer'] : [$answer['answer']];
            list($is_correct, $correct_answer) = GraderManger::grade($question, $answerArray);

            $this->constructData($is_correct, $question, $answerArray, $correct_answer);
        }
    }

    /**
     * @param $is_correct
     * @param $question
     * @param $answerArray
     * @param $correct_answer
     */
    private function constructData($is_correct, $question, $answerArray, $correct_answer) {
        $this->summary['correct'] = $is_correct ? $this->summary['correct'] + 1 : $this->summary['correct'];
        $this->result[] = [
            'id'             => $question->id,
            'input'          => $answerArray,
            'is_correct'     => $is_correct,
            'correct_answer' => $correct_answer,
        ];
    }
}