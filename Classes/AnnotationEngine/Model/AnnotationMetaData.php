<?php


namespace TheWorldsCMS\Journey\AnnotationEngine\Model;

/**
 * Class AnnotationMetaData
 * @package TheWorldsCMS\Packages\Journey\Classes\AnnotationEngine
 * Soll die Daten der Annotation (string) und der damit verbundenen AnnotationProperties beinhalten, damit die annotate
 * Funktion mit den richtigen Parametern aufgerufen werden
 */
class AnnotationMetaData {

    /**
     * AnnotationMetaData constructor.
     * @param string $annotationExpression
     */
    public function __construct(string $annotationExpression) {
        $this->annotationExpression = $annotationExpression;
    }

    /**
     * @var string
     */
    protected $annotationExpression;

    /**
     * @var AnnotationProperty[]|null
     */
    protected $annotationProperties;

    /**
     * @return AnnotationProperty[]|null
     */
    public function getAnnotationProperties() {
        return $this->annotationProperties;
    }

    /**
     * @param AnnotationProperty[] $annotationProperties
     */
    public function setAnnotationProperties(array $annotationProperties): void {
        $this->annotationProperties = $annotationProperties;
    }

    /**
     * @return string
     */
    public function getAnnotationExpression(): string {
        return $this->annotationExpression;
    }

    /**
     * @param string $annotationExpression
     */
    public function setAnnotationExpression(string $annotationExpression): void {
        $this->annotationExpression = $annotationExpression;
    }

}