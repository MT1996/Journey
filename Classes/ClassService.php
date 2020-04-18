<?php


namespace TheWorldsCMS\Journey;

use Composer\Autoload\ClassLoader;
use TheWorldsCMS\Journey\Annotations as Journey;
use TheWorldsCMS\Journey\Exceptions\ClassNotFoundException;

/**
 * Class ClassService
 * @package TheWorldsCMS\Packages\Journey\Classes
 */
class ClassService {

    /**
     * @var ClassLoader
     */
    protected $classLoader;

    public function __construct(ClassLoader $classLoader) {
        $this->classLoader = $classLoader;
    }

    /**
     * @return array
     */
    public function findAllClassesInProject() {
        return $this->findAllClassesWithinANamespace(THEWORLDSCMS_NAMESPACE);
    }

    /**
     * @param string $classNamespace
     * @return array
     */
    public function findAllClassesWithinANamespace(string $classNamespace) {
        $classesWithinNamespace = [];
        foreach ($this->classLoader->getClassMap() as $tmpClassName => $tmpClassFile) {
            if ($this->composerContainsClassInClassmap($classNamespace, THEWORLDSCMS_ALL_CLASSES, $tmpClassName)) {
                $classesWithinNamespace[] = $tmpClassName;
            }
        }
        return $classesWithinNamespace;
    }

    /**
     * @param string $classNamespace
     * @param string $className
     * @return int|string
     * @throws ClassNotFoundException
     */
    public function findClassByNamespaceAndClassname(string $classNamespace, string $className) {
        foreach ($this->classLoader->getClassMap() as $tmpClassName => $tmpClassFile) {
            if ($this->composerContainsClassInClassmap($classNamespace, $className, $tmpClassName)) {
                return $tmpClassName;
            }
        }
        //Wenn keine Klasse innerhalb des angegeben Namespaces gefunden wurde, stimmt was mit dem ClassLoader nicht...
        throw new ClassNotFoundException("ClassLoader nicht richtig eingesetzt!!");
    }

    /**
     * @param string $classNameSpace
     * @param string $className
     * @param string $composerClass
     * @return bool
     */
    private function composerContainsClassInClassmap(string $classNameSpace, string $className, string $composerClass) {
        return (preg_match("/^$classNameSpace\\\[a-zA-Z\S]*\\\\$className/", $composerClass) == 1);
    }
}