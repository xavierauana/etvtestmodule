<?php
/**
 * Author: Xavier Au
 * Date: 20/1/2017
 * Time: 3:05 AM
 */

namespace Anacreation\Etvtest\Services;

use Anacreation\Etvtest\Factory\QuestionCreatorFactory;
use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\Test;

/**
 * Class CreateQuestionService
 * @package Anacreation\Etvtest\Services
 */
class CreateQuestionService
{
    /**
     * @param array $inputs
     * @param       $testId
     * @return Question
     */
    public function create(array $inputs, $testId) {

        if (!isset($inputs['question_type_id'])) {
            throw new \InvalidArgumentException("invalid array");
        }

        $questionCreator = QuestionCreatorFactory::make($inputs['question_type_id']);

        $test = Test::findOrFail($testId);

        return $questionCreator->create($inputs, $test);

    }
}