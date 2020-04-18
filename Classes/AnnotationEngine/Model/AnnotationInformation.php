<?php


namespace TheWorldsCMS\Journey\AnnotationEngine\Model;

class AnnotationInformation {

    /**
     * @var string
     */
    protected $annotatedClass;

    /**
     * @var Annotation[]
     */
    protected $classAnnotations;

    /**
     * @var array
     * Dieses Array besitzt quasi die PropertyAnnotations jedoch, ist der propertyName der identifizierende Key des Arrays,
     * was dann ein Array aus dem Annotations besitzt, die diese Property bekommen hat
     */
    protected $propertyAnnotations;

    /**
     * @var Annotation[]
     */
    protected $methodAnnotations;

    /**
     * @return Annotation[]|null
     */
    public function getMethodAnnotations()
    {
        return $this->methodAnnotations;
    }

    /**
     * @param Annotation[] $methodAnnotations
     */
    public function setMethodAnnotations(array $methodAnnotations): void
    {
        $this->methodAnnotations = $methodAnnotations;
    }

    /**
     * @return Annotation[]|null
     */
    public function getPropertyAnnotations()
    {
        return $this->propertyAnnotations;
    }

    /**
     * @param Annotation[] $propertyAnnotations
     */
    public function setPropertyAnnotations(array $propertyAnnotations): void
    {
        $this->propertyAnnotations = $propertyAnnotations;
    }

    /**
     * @return string
     */
    public function getAnnotatedClass(): string
    {
        return $this->annotatedClass;
    }

    /**
     * @param string $annotatedClass
     */
    public function setAnnotatedClass(string $annotatedClass): void
    {
        $this->annotatedClass = $annotatedClass;
    }

    /**
     * @return Annotation[]|null
     */
    public function getClassAnnotations()
    {
        return $this->classAnnotations;
    }

    /**
     * @param Annotation[] $classAnnotations
     */
    public function setClassAnnotations(array $classAnnotations): void
    {
        $this->classAnnotations = $classAnnotations;
    }

}