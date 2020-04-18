<?php
namespace TheWorldsCMS\Packages\Journey\Classes\Annotations;

use ReflectionClass;
use ReflectionException;
use TheWorldsCMS\Journey\AnnotationEngine\Model\AnnotationProperty;
use TheWorldsCMS\Journey\Annotations\AbstractAnnotation;

/**
 * Class Injection
 * @package TheWorldsCMS\Packages\Journey\Classes\Annotations
 * @Annotation
 */
class Injection extends AbstractAnnotation {
    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public function annotate($targetClass, $paramters) {
        /** @var AnnotationProperty $annotationProperty */
        $annotationProperty = $paramters["annotationProperties"][0];
        $propertyName = $paramters["propertyName"];
        $ClassStringThatWillBeInjected = $annotationProperty->getAnnotationPropertyValue();
        $instanceThatWillBeInjected = null;
        $reflectedClassStringClass = new ReflectionClass($ClassStringThatWillBeInjected);
        If (Injection::reflectedClassIsInstantiable($reflectedClassStringClass)) {
            $instanceThatWillBeInjected = new $ClassStringThatWillBeInjected();
        } else {
            $instanceThatWillBeInjected = $ClassStringThatWillBeInjected::getInstance();
        }
        $reflectedTargetClass = new ReflectionClass($targetClass);
        $targetClassInstance = null;
        if (Injection::reflectedClassIsInstantiable($reflectedTargetClass)) {
            $targetClassInstance = new $targetClass();
        } else {
            $targetClassInstance = $targetClass::getInstance();
        }
        $reflectedProperty = $reflectedTargetClass->getProperty($propertyName);
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue($targetClassInstance, $instanceThatWillBeInjected);
        $reflectedProperty->setAccessible(false);
    }

    private static function reflectedClassIsInstantiable(ReflectionClass $reflectedClass) {
        return $reflectedClass->isInstantiable();
    }
}