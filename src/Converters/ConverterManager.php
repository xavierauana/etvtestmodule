<?php
/**
 * Author: Xavier Au
 * Date: 1/2/2017
 * Time: 9:48 PM
 */

namespace Anacreation\Etvtest\Converters;


use Anacreation\Etvtest\Models\Question;

class ConverterManager
{
    private $data;
    private $object = null;
    private $type = null;

    /**
     * @param null $object
     */
    public function setObject($object) {
        $this->object = $object;
    }


    /**
     * @param $subject
     * @return $this
     */
    private function _convert() {

        /** @var ConverterInterface $converter */
        $converter = $this->instantiateProperConverter();

        $this->data = $converter->convert($this->object);

        return $this;
    }

    public static function convert($object, string $ConverterType = ConverterType::ATTEMPT): ConverterManager {
        $instance = new self();
        $instance->type = $ConverterType;
        if ($instance->object == null) {
            $instance->setObject($object);
        }

        return $instance->_convert();

    }

    /**
     * @param $subject
     * @return ConverterInterface
     */
    private function instantiateProperConverter() {

        if (get_class($this->object) === Question::class) {
            return QuestionConverterFactory($this->object, $this->type);
        }

        $reflection = new \ReflectionClass(get_class($this->object));
        $subject_class = $reflection->getShortName();

        $self_reflection = new \ReflectionClass(get_class($this));
        $namespace = $self_reflection->getNamespaceName();

        $convert_full_name = $namespace . "\\" . $subject_class . "Converter";

        return new $convert_full_name;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }


}