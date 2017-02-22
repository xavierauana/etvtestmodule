<?php
/**
 * Author: Xavier Au
 * Date: 14/2/2017
 * Time: 7:24 PM
 */

namespace Anacreation\Etvtest\Services;


use Anacreation\Etvtest\Models\QuestionType;
use Illuminate\Support\Collection;

class QuestionTypeServices
{
    public function getQuestionTypes(): Collection {
        return QuestionType::select('id', 'code', 'label')->get();
    }
    public function getQuestionTypeByCode($code): QuestionType {
        return QuestionType::whereCode($code)->firstOrFail();
    }
}