<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 12:17 AM
 */

namespace Anacreation\Etvtest\Converters;


use Anacreation\Etvtest\Factory\QuestionConverterFactory;
use Anacreation\Etvtest\Models\Test;
use Illuminate\Support\Collection;

class TestConverter
{
    private $type;

    /**
     * TestConverter constructor.
     * @param $type
     */
    public function __construct(string $type = ConverterType::ATTEMPT) {
        $this->type = $type;
    }


    public function convert(Test $test) {
        $data = [];

        $data['title'] = $test->title;
        $data['questions'] = $this->convertQuestions($test->questions);

        return $data;
    }

    public function convertQuestions(Collection $questions) {
        $questionsArray = [];
        foreach ($questions as $question) {
            /** @var \Anacreation\Etvtest\Converters\ConverterInterface $converter */
            $converter = QuestionConverterFactory::make($question, $this->type);
            $questionsArray[] = $converter->convert($question)[0];
        }

        return $questionsArray;
    }
}