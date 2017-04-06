<?php
/**
 * Author: Xavier Au
 * Date: 6/4/2017
 * Time: 10:57 PM
 */

namespace Anacreation\Etvtest\Graders;


trait GraderTrait
{

    public function isEmptyAnswer(array $answers): bool  {
        return  !count($answers);
    }
}