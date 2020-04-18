<?php


namespace TheWorldsCMS\Journey\AnnotationEngine\Model;

class AnnotationProperty {

    /**
     * @var string
     */
    protected $annotationPropertyKey;

    /**
     * @var string
     */
    protected $annotationPropertyValue;

    public function __construct(string $annotationPropertyKey, string $annotationPropertyValue) {
        $this->annotationPropertyKey = $annotationPropertyKey;
        $this->annotationPropertyValue = $annotationPropertyValue;
    }

    /**
     * @return string
     */
    public function getAnnotationPropertyValue(): string {
        return $this->annotationPropertyValue;
    }

    /**
     * @return string
     */
    public function getAnnotationPropertyKey(): string {
        return $this->annotationPropertyKey;
    }

    /**
     * @param string $annotationPropertyKey
     */
    public function setAnnotationPropertyKey(string $annotationPropertyKey): void {
        $this->annotationPropertyKey = $annotationPropertyKey;
    }

    /**
     * @param string $annotationPropertyValue
     */
    public function setAnnotationPropertyValue(string $annotationPropertyValue): void {
        $this->annotationPropertyValue = $annotationPropertyValue;
    }

}