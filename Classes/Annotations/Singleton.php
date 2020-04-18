<?php
namespace TheWorldsCMS\Journey\Annotations;

use Closure;
use ReflectionException;

/**
 * Class Singleton
 * @package TheWorldsCMS\Packages\Journey\Classes\Annotations
 * @Annotation
 */
class Singleton extends AbstractAnnotation {

    private static $function_name = 'getInstance';

    /**
     * @param mixed $targetClass
     * @param array $parameters
     * @throws ReflectionException
     */
    public function annotate($targetClass, $parameters) {
        $singletonClosureForAnnotatedClass = static function() use ($targetClass) {
            $className = get_called_class();
            if (isset($targetClass::$controllerInstance[$className]) == false) {
                /** @var array $controllerInstance */
                $targetClass::$controllerInstance[$className] = new $targetClass();
            }
            return $targetClass::$controllerInstance[$className];
        };
        /** @var array $staticClassMethods */
        $targetClass::$staticClassMethods[$targetClass][self::$function_name] = Closure::bind($singletonClosureForAnnotatedClass, null, $targetClass);
    }
}