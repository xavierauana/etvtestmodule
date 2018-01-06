<?php
/**
 * Author: Xavier Au
 * Date: 24/6/2017
 * Time: 3:37 PM
 */

use App\Page;

return [
    'testable_class'       => [
        'page' => Page::class
    ],
    'test_observation'     => env('TEST_OBSERVATION', false),
    'choice_observation'   => env('CHOICE_OBSERVATION', false),
    'question_observation' => env('QUESTION_OBSERVATION', false),
    'record_table'         => env('RECORD_TABLE'),
];