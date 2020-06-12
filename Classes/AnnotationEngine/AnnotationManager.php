<?php
namespace TheWorldsCMS\Journey\AnnotationEngine;

use TheWorldsCMS\Journey\AnnotationEngine\Model\Annotation;
use TheWorldsCMS\Journey\AnnotationEngine\Model\AnnotationInformation;
use TheWorldsCMS\Journey\AnnotationEngine\Model\AnnotationMetaData;
use TheWorldsCMS\Journey\ClassService;

class AnnotationManager {

    /**
     * @var ClassService
     */
    protected $classService;

    /**
     * @var AnnotationService
     */
    protected $annotationService;

    /**
     * @var AnnotationInformation[]
     * Liste aller Klassen, die in irgendeiner Art und Weise erweitert wurden mit dementsprechenden Properties und Values
     * falls die Annotation Properties und Values in den Klammern definiert
     */
    protected $annotationInformationList;

    /**
     * AnnotationManager constructor.
     * @param ClassService $classService
     * @param AnnotationService $annotationService
     */
    public function __construct(ClassService $classService, AnnotationService $annotationService) {
        $this->classService = $classService;
        $this->annotationService = $annotationService;
    }

    /**
     *
     */
    public function enhanceClassesWithAnnotations() {
        $projectClasses = $this->classService->findAllClassesInProject();
        //Finde mir mit Hilfe des Services alle Klassen die annotiert werden sollen
        //D.h. checken, ob Klassen oder Property Annotationen
        $this->annotationInformationList = $this->annotationService->findAllAnnotatedClassesByAnnotationNamespace($projectClasses, THEWORLDSCMS_ANNOTATION_NAMESPACE);
        //Zuerst sollen alle Klassen mit ihren dementsprechenden Klassenannotationen erweitert werden
        $this->enhanceAllClassesWithClassAnnotations();
        //Danach sollen die Propertyannotationen ausgeführt werden, die dann mit den bestimmten Funktionen ausgeführt werden
        $this->enhanceAllClassesWithPropertyAnnotations();
        //Danach sollen die MethodAnnotationen ausgeführt werden, die dann mit den bestimmten Funktionen ausgeführt werden
        $this->enhanceAllClassesWithMethodProperties();
        //$this->annotationService->annotateAllFoundClasses();
    }

    private function enhanceAllClassesWithClassAnnotations() {
        foreach ($this->annotationInformationList as $annotationInformation) {
            /** @var Annotation[] $classAnnotations */
            $classAnnotations = $annotationInformation->getClassAnnotations();
            foreach ($classAnnotations as $classAnnotation) {
                /** @var AnnotationMetaData[] $annotationExpressions */
                $annotationMetaDataList = $classAnnotation->getAnnotationsForExpression();
                foreach ($annotationMetaDataList as $annotationMetaData) {
                    call_user_func_array(
                        array(
                            $annotationMetaData->getAnnotationExpression(),
                            THEWORLDSCMS_DEFAULT_ANNOTATION_FUNCTION
                        ),
                        array(
                            $annotationInformation->getAnnotatedClass(),
                            $annotationMetaData->getAnnotationProperties()
                        )
                    );
                }
            }
        }
    }

    private function enhanceAllClassesWithPropertyAnnotations() {
        /** @var AnnotationInformation $annotationInformation */
        foreach ($this->annotationInformationList as $annotationInformation) {
            $propertyAnnotationsList = $annotationInformation->getPropertyAnnotations();
            if ($propertyAnnotationsList == null) {
                continue;
            }
            foreach ($propertyAnnotationsList as $propertyName => $propertyAnnotations) {
                /** @var Annotation $annotation */
                foreach ($propertyAnnotations as $annotation) {
                    foreach ($annotation->getAnnotationsForExpression() as $annotationMetaData) {
                        call_user_func_array(
                            array(
                                $annotationMetaData->getAnnotationExpression(),
                                THEWORLDSCMS_DEFAULT_ANNOTATION_FUNCTION
                            ),
                            array(
                                $annotationInformation->getAnnotatedClass(),
                                array(
                                    "annotationProperties" => $annotationMetaData->getAnnotationProperties(),
                                    "propertyName" => $propertyName
                                )
                            )
                        );
                    }
                }
            }

        }
    }

    private function enhanceAllClassesWithMethodProperties() {

    }
}