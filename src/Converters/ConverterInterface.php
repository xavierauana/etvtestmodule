<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 12:32 AM
 */

namespace Anacreation\Etvtest\Converters;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ConverterInterface
{
    /**
     * @param Model|Collection $subject
     */
    public function convert($subject):array;
}