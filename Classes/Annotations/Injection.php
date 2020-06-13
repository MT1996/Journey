<?php
namespace TheWorldsCMS\Journey\Annotations;

use ReflectionClass;
use ReflectionException;
use TheWorldsCMS\Journey\AnnotationEngine\Model\AnnotationProperty;

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
        $reflectedClassStringClass = new ReflectionClass($ClassStringThatWillBeInjected);

        $instanceThatWillBeInjected = (Injection::reflectedClassIsInstantiable($reflectedClassStringClass) ? new $ClassStringThatWillBeInjected() : $ClassStringThatWillBeInjected::getInstance());

        $reflectedTargetClass = new ReflectionClass($targetClass);

        $targetClassInstance = (Injection::reflectedClassIsInstantiable($reflectedTargetClass) ? new $targetClass() : $targetClass::getInstance());

        $reflectedProperty = $reflectedTargetClass->getProperty($propertyName);
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue($targetClassInstance, $instanceThatWillBeInjected);
        $reflectedProperty->setAccessible(false);
    }

    private static function reflectedClassIsInstantiable(ReflectionClass $reflectedClass) {
        return $reflectedClass->isInstantiable();
    }
}