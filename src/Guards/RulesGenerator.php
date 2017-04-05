<?php
/**
 * Author: Xavier Au
 * Date: 2/4/2017
 * Time: 7:31 PM
 */

namespace Anacreation\Etvtest\Guards;


use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\QuestionType;
use Illuminate\Support\Facades\Cache;

class RulesGenerator
{

    public static function make(Question $question): array {

        return (new self())->getRules($question->code);

    }

    private function getRules(String $questionTypeCode): array {
        $question_types = $question_types = Cache::remember('question_types', 60, function () {
            return QuestionType::all();
        });
        $question_type_id_array = [];

        $question_types->each(function ($type) use ($question_type_id_array) {
            $question_type_id_array[] = $type->id;
        });

        $rules = [
            "SingleMultipleChoice" => [
                "id"               => "integer",
                "answer"           => "array",
                "prefix"           => "nullable",
                "content"          => "nullable",
                "choices"          => "array",
                "page_number"      => "integer",
                "sub_questions"    => "array",
                "is_active"        => "boolean",
                "question_type_id" => "required|in:" . implode(",", $question_type_id_array),
                "is_required_all"  => "boolean",
                "is_ordered"       => "boolean",
                "is_fractional"    => "boolean",
            ],
            "MultipleMultipleChoice" => [
                "id"               => "integer",
                "answer"           => "array",
                "prefix"           => "nullable",
                "content"          => "nullable",
                "choices"          => "array",
                "page_number"      => "integer",
                "sub_questions"    => "array",
                "is_active"        => "boolean",
                "question_type_id" => "required|in:" . implode(",", $question_type_id_array),
                "is_required_all"  => "boolean",
                "is_ordered"       => "boolean",
                "is_fractional"    => "boolean",
            ],
            "choice" => [
                "id"               => "integer",
                "content"          => "nullable"
            ],
        ];

        return $rules[$questionTypeCode];
    }


}