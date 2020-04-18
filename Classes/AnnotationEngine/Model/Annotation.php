<?php


namespace TheWorldsCMS\Journey\AnnotationEngine\Model;

/**
 * Class ClassAnnotation
 * @package TheWorldsCMS\Packages\Journey\Classes\AnnotationEngine
 */
class Annotation {

    protected $annotationsForExpression;

    /**
     * ClassAnnotation constructor.
     */
    public function __construct() {
    }

    /**
     * @return AnnotationMetaData[]
     */
    public function getAnnotationsForExpression() {
        return $this->annotationsForExpression;
    }

    /**
     * @param AnnotationMetaData[] $annotationsForExpression
     */
    public function setAnnotationsForExpression(array $annotationsForExpression): void {
        $this->annotationsForExpression = $annotationsForExpression;
    }

}