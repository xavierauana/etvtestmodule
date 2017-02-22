<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 12:36 AM
 */

namespace Anacreation\Etvtest\Converters;


use Illuminate\Support\Collection;

abstract class AbstractConverter implements ConverterInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection $subject
     * @return array
     */
    public function convert($subject):array  {
        $data = [];
        if($subject instanceof Collection ){
            if($subject->count() > 0){
                $subjects = $subject;
                foreach ($subjects as $subject){
                    $data[] = $this->_convert($subject);
                }
            }
        }else{
            $data[] = $this->_convert($subject);
        }
            return $data;

    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @return array
     */
    abstract protected function _convert($subject);
}