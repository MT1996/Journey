<?php


namespace TheWorldsCMS\Journey\Annotations;


abstract class AbstractAnnotation {

    /**
     * @param mixed $targetClass
     * @param mixed $paramters
     * @return mixed
     */
    abstract public function annotate($targetClass, $paramters);

}