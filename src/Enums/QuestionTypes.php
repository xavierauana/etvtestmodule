<?php namespace Anacreation\Etvtest\Enums;

/**
 * Author: Xavier Au
 * Date: 26/3/2018
 * Time: 1:38 PM
 */

class QuestionTypes
{
    const SingleMultipleChoice   = \Anacreation\Etvtest\QuestionType\SingleMultipleChoice::class;
    const MultipleMultipleChoice = \Anacreation\Etvtest\QuestionType\MultipleMultipleChoice::class;
    const InlineMultipleChoice   = \Anacreation\Etvtest\QuestionType\InlineMultipleChoice::class;
    const InlineFillInBlanks     = \Anacreation\Etvtest\QuestionType\InlineFillInBlanks::class;
    const Reorder                = \Anacreation\Etvtest\QuestionType\Reorder::class;
    const MultipleFillInBlanks   = \Anacreation\Etvtest\QuestionType\MultipleFillInBlanks::class;
}