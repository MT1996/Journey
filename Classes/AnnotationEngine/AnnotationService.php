<?php


namespace TheWorldsCMS\Journey\AnnotationEngine;

use ReflectionClass;
use ReflectionException;
use TheWorldsCMS\Journey\AnnotationEngine\Model\AnnotationInformation;
use TheWorldsCMS\Journey\ClassService;

class AnnotationService {

    /**
     * @var ClassService
     */
    protected $classService;

    /**
     * @var array
     */
    protected $annotatedClasses;

    /**
     * AnnotationService constructor.
     * @param ClassService $classService
     */
    public function __construct(ClassService $classService) {
        $this->classService = $classService;
    }

    /**
     * @param array $projectClasses
     * @param string $annotationNamespace
     * @return AnnotationInformation[]
     * Kann Annotation der Form AnnotationNamespace\AnnotationName(Property1) bisher erkennen soll erweitert werden zu
     * AnnotationNamespace\AnnotationName(Property-1, ... , Property-N), Aufbau der Datenstruktur auf Membervariable besser, da bessere
     * Kontrolle auf Zugriff und Zuweisung der Variable
     */
    public function findAllAnnotatedClassesByAnnotationNamespace(array $projectClasses, string $annotationNamespace) {
        /** @var AnnotationInformation[] $allAnnotationsForClasses */
        $allAnnotationsForClasses = [];
        foreach ($projectClasses as $className) {
            try {
                $reflectedClass = new ReflectionClass($className);
                $annotationParser = new AnnotationParser($reflectedClass, $this->classService);
                $classHasAnnotateAbleExpression = $annotationParser->checkForExistingAnnotationNamespace($annotationNamespace);
                if ($classHasAnnotateAbleExpression) {
                    $allAnnotationsForClasses[] = $annotationParser->parseAnnotations();
                } else {
                    continue;
                }
            } catch (ReflectionException $e) {
                $e->getTrace();
            }
        }
        return $allAnnotationsForClasses;
    }

    /**
     * Annotations Calling geschieht hier...
     */
    public function annotateAllFoundClasses() {
        foreach ($this->annotatedClasses as $targetClass => $multipleAnnotationsForClass) {
            foreach ($multipleAnnotationsForClass as $annotationType => $annotationsForClass) {
                foreach ($annotationsForClass as $annotationForClass) {
                    if ($annotationForClass != null) {
                        call_user_func(
                            array(
                                $annotationForClass,
                                THEWORLDSCMS_DEFAULT_ANNOTATION_FUNCTION
                            ),
                            $targetClass
                        );
                    }
                }
            }
        }
    }
}