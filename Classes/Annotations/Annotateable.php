<?php


namespace TheWorldsCMS\Journey\Annotations;


interface Annotateable {
    public static function __callStatic($name, $arguments);
    public function __call($name, $arguments);
}