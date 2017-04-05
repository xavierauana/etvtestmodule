<?php
/**
 * Author: Xavier Au
 * Date: 6/4/2017
 * Time: 1:08 AM
 */

namespace Anacreation\Etvtest\Converters;


use Anacreation\Etvtest\Models\Attempt;

class AttemptConverter implements ConverterInterface
{

    /**
     * @param Attempt $subject
     */
    public function convert($subject): array {
        return [
            "attempt" => $subject->attempt,
            "score" => $subject->score,
        ];
    }
}