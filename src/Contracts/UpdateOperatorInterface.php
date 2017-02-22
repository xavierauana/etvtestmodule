<?php
/**
 * Author: Xavier Au
 * Date: 17/2/2017
 * Time: 4:33 PM
 */

namespace Anacreation\Etvtest\Contracts;


use Anacreation\Etvtest\Models\Question;

/**
 * Interface UpdateOperatorInterface
 * @package Anacreation\Etvtest\Contracts
 */
interface UpdateOperatorInterface
{
    /**
     * @param \Anacreation\Etvtest\Models\Question $question
     * @param array                                $data
     * @return \Anacreation\Etvtest\Models\Question
     */
    public function update(Question $question, array $data): Question;

}