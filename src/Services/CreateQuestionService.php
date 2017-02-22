<?php
/**
 * Author: Xavier Au
 * Date: 20/1/2017
 * Time: 3:05 AM
 */

namespace Anacreation\Etvtest\Services;

use Anacreation\Etvtest\Contracts\CreateQuestionInterface;
use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\QuestionType;
use Anacreation\Etvtest\Models\Test;

/**
 * Class CreateQuestionService
 * @package Anacreation\Etvtest\Services
 */
class CreateQuestionService
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|static[]
     */
    private $questionTypes;

    /**
     * CreateQuestionService constructor.
     */
    public function __construct() {
        $this->questionTypes = QuestionType::all();
    }


    /**
     * @param array $inputs
     * @param       $testId
     * @return Question
     */
    public function create(array $inputs, $testId) {

        if (!isset($inputs['question_type_id'])) {
            throw new \InvalidArgumentException("invalid array");
        }

        $object = $this->createObject($inputs);

        $test = Test::findOrFail($testId);

        return $object->create($inputs, $test);

    }

    /**
     * @param $inputs
     * @return CreateQuestionInterface
     * @throws \Exception
     */
    private function createObject($inputs) {

        $type = $this->questionTypes->first(function ($type) use ($inputs) {
            return $type->id == $inputs['question_type_id'];
        });

        if (!$type) {
            throw new \InvalidArgumentException("Invalid question type");
        }

        $object = app("Anacreation\\Etvtest\\QuestionType\\" . $type->code);

        if ($object instanceof CreateQuestionInterface) {
            return $object;
        }

        throw new \Exception("No Class {$type->code} fulfill interface.");
    }

}