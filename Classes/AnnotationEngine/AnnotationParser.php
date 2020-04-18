<?php


namespace TheWorldsCMS\Packages\Journey\Classes\AnnotationEngine;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Reflector;
use TheWorldsCMS\Journey\AnnotationEngine\Model\AnnotationInformation;
use TheWorldsCMS\Journey\ClassService;
use TheWorldsCMS\Journey\Exceptions\ClassNotFoundException;

/**
 * Class AnnotationParser
 * @package TheWorldsCMS\Packages\Journey\Classes\AnnotationEngine
 */
class AnnotationParser {
    /**
     * @var Reflector
     * Kann nachher alles sein, Funktion, Property, Class
     * Alle Objekte, die das Interface Reflector implementieren, können hier geparst werden
     */
    protected $reflectedClass;

    protected $classService;

    /**
     * AnnotationParser constructor.
     * @param ReflectionClass $reflectedClass
     * @param ClassService $classService
     */
    public function __construct(ReflectionClass $reflectedClass, ClassService $classService) {
        $this->reflectedClass = $reflectedClass;
        $this->classService = $classService;
    }

    /**
     * @return null
     */
    public function parseAnnotations() {
        $annotationInformation = new AnnotationInformation();
        if ($this->ReflectionClassHasAnnotationsInNamespace($this->reflectedClass, THEWORLDSCMS_ANNOTATION_NAMESPACE)) {
            //Klasse definiert Annotationen die geparsed werden müssen...
            $tmpAnnotationsForClass = $this->getAllAnnotationsFromAnnotatedExpression($this->reflectedClass->getDocComment());
            $annotationInformation->setAnnotatedClass($this->reflectedClass->getName());
            $annotationInformation->setClassAnnotations($tmpAnnotationsForClass);
        }
        if ($this->ReflectionPropertiesHaveAnnotationInNamespace($this->reflectedClass->getProperties(), THEWORLDSCMS_ANNOTATION_NAMESPACE)) {
            //Properties der Klasse definieren Annotationen die geparsed werden müssen...
            $tmpAnnotationsForProperties = [];
            foreach ($this->reflectedClass->getProperties() as $reflectedProperty) {
                try {
                    if ($this->reflectorContainsAnnotationFromNamespace($reflectedProperty, THEWORLDSCMS_ANNOTATION_NAMESPACE)) {
                        $tmpAnnotationsForProperties[$reflectedProperty->getName()] = $this->getAllAnnotationsFromAnnotatedExpression($reflectedProperty->getDocComment());
                    } else {
                        continue;
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                    die();
                }
            }
            $annotationInformation->setPropertyAnnotations($tmpAnnotationsForProperties);
        }
        if ($this->ReflectionMethodsHaveAnnotationsInNamespace($this->reflectedClass->getMethods(), THEWORLDSCMS_ANNOTATION_NAMESPACE)) {
            $tmpAnnotationsForMethods = [];
            foreach ($this->reflectedClass->getMethods() as $reflectedMethod) {
                try {
                    if ($this->reflectorContainsAnnotationFromNamespace($reflectedMethod, THEWORLDSCMS_ANNOTATION_NAMESPACE)) {
                        $tmpAnnotationsForMethods[$reflectedMethod->getName()] = $this->getAllAnnotationsFromAnnotatedExpression($reflectedMethod->getDocComment());
                    } else {
                        continue;
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                    die();
                }
            }
            $annotationInformation->setMethodAnnotations($tmpAnnotationsForMethods);
        }
        return $annotationInformation;
    }

    /**
     * @param string $annotationString
     * @return false|int
     */
    private function annotationDefinesAnnotationProperties(string $annotationString) {
        return preg_match("/\((.+?)\)/", trim($annotationString, " @\t\n\r\0\x0B"));
    }

    /**
     * @param ReflectionClass $reflectedClass
     * @param string $annotationNamespace
     * @return bool
     */
    private function ReflectionClassHasAnnotationsInNamespace($reflectedClass, $annotationNamespace) {
        try {
            return $this->reflectorContainsAnnotationFromNamespace($reflectedClass, $annotationNamespace);
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    /**
     * @param ReflectionMethod[] $reflectedMethods
     * @param $annotationNamespace
     * @return bool
     */
    private function ReflectionMethodsHaveAnnotationsInNamespace($reflectedMethods, $annotationNamespace): bool {
        $docCommentsContainsAnnotation = false;
        foreach ($reflectedMethods as $reflectedMethod) {
            try {
                if ($this->reflectorContainsAnnotationFromNamespace($reflectedMethod, $annotationNamespace)) {
                    $docCommentsContainsAnnotation = $docCommentsContainsAnnotation || true;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                die();
            }
        }
        return $docCommentsContainsAnnotation;
    }

    /**
     * @param ReflectionProperty[] $reflectedProperties
     * @param string $annotationNamespace
     * @return bool
     */
    private function ReflectionPropertiesHaveAnnotationInNamespace($reflectedProperties, $annotationNamespace): bool {
        $docCommentsContainsAnnotation = false;
        foreach ($reflectedProperties as $reflectedProperty) {
            try {
                if ($this->reflectorContainsAnnotationFromNamespace($reflectedProperty, $annotationNamespace)) {
                    $docCommentsContainsAnnotation = $docCommentsContainsAnnotation || true;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                die();
            }
        }
        return $docCommentsContainsAnnotation;
    }

    /**
     * @param string $annotationNamespace
     * @return bool
     */
    public function checkForExistingAnnotationNamespace(string $annotationNamespace) {
        try {
            return
                $this->ReflectionClassHasAnnotationsInNamespace($this->reflectedClass, $annotationNamespace) ||
                $this->ReflectionMethodsHaveAnnotationsInNamespace($this->reflectedClass->getMethods(), $annotationNamespace) ||
                $this->ReflectionPropertiesHaveAnnotationInNamespace($this->reflectedClass->getProperties(), $annotationNamespace);
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    /**
     * @param Reflector $reflector
     * @param string $annotationNamespace
     * @return bool
     * @throws Exception
     */
    private function reflectorContainsAnnotationFromNamespace(Reflector $reflector, string $annotationNamespace) {
        if ($reflector instanceof ReflectionMethod || $reflector instanceof ReflectionProperty || $reflector instanceof ReflectionClass) {
            if ($reflector->getDocComment() != false) {
                return $this->docCommentContainsAnnotationFromNamespace($reflector->getDocComment(), $annotationNamespace);
            } else {
                return false;
            }
        } else {
            throw new \Exception("reflector ist keine Property, Method oder Class");
        }
    }

    /**
     * @param string $docComment
     * @param string $annotationNamespace
     * @return bool
     */
    private function docCommentContainsAnnotationFromNamespace(string $docComment, string $annotationNamespace) {
        $docCommentarsOfReflectedClass = preg_split("/\*/", $docComment);
        $docCommentContainsAnnotationFromNamespace = false;
        foreach ($docCommentarsOfReflectedClass as $docCommentarOfReflectedClass) {
            $classNameForInjection = trim($docCommentarOfReflectedClass, " @\t\n\r\0\x0B");
            $docCommentContainsAnnotationFromNamespace = $docCommentContainsAnnotationFromNamespace || (preg_match("/^$annotationNamespace/", $classNameForInjection) == 1);
        }
        return $docCommentContainsAnnotationFromNamespace;
    }

    /**
     * @param string $docComment
     * @param string $annotationNamespace
     * @return string[]
     */
    private function docCommentToTrimmedStringArray(string $docComment, string $annotationNamespace) {
        $trimmedDocComments = [];
        $docCommentarsOfReflectedClass = preg_split("/\*/", $docComment);
        foreach ($docCommentarsOfReflectedClass as $docCommentarOfReflectedClass) {
            $classNameForInjection = trim($docCommentarOfReflectedClass, " @\t\n\r\0\x0B");
            if (preg_match("/^$annotationNamespace/", $classNameForInjection) == 1) {
                $trimmedDocComments[] = $classNameForInjection;
            }
        }
        return $trimmedDocComments;
    }

    /**
     * @param $docComment
     * @return string
     * TODO: Nochmal neu schreiben mit einer Stringhelper Klasse, die static functions beinhaltet und dann diese Sachen
     * für mich übernimmt, sonst passt das
     */
    private function getAnnotationclassstringFromDocCommentLine($docComment) {
        $splittedDocComment = preg_split("/\\\\/", $docComment);
        $classStringWithParentheses = preg_split("/\(/", $splittedDocComment[1]);
        return trim($classStringWithParentheses[0], " ()@\t\n\r\0\x0B");
    }

    /**
     * @param string $docComment
     * @return AnnotationProperty[]
     */
    private function getAllAnnotationPropertiesWithinParentheses(string $docComment) {
        $annotationProperties = preg_split("/\(/", $docComment)[1];
        $annotationProperties = trim($annotationProperties, " ()@\t\n\r\0\x0B");
        $annotationProperties = preg_replace("/\s+/", "", $annotationProperties);
        //TODO: Geht bestimmt besser in dem man ein Pattern der möglichen EIngaben machen könnte, geht aber erstmal so...
        if (preg_match("/\,/", $annotationProperties)) {
            $annotationProperties = preg_split("/\,/", $annotationProperties);
        } else if (preg_match("/[a-zA-Z]+/", $annotationProperties)) {
            try {
                $qualifiedClassString = $this->classService->findClassByNamespaceAndClassname(THEWORLDSCMS_NAMESPACE, $annotationProperties);
            } catch (ClassNotFoundException $e) {
                $e->getMessage();
                die();
            }
            $annotationProperties = ["$annotationProperties=$qualifiedClassString"];
        }
        return $this->convertAnnotationPropertyStringArrayToAnnotationPropertyInstances($annotationProperties);
    }

    /**
     * @param array $annotationProperties
     * @return AnnotationProperty[]
     */
    private function convertAnnotationPropertyStringArrayToAnnotationPropertyInstances(array $annotationProperties) {
        /** @var AnnotationProperty[] $annotationPropertiesInstances */
        $annotationPropertiesInstances = [];
        foreach ($annotationProperties as $annotationProperty) {
            $splittedAnnotationProperty = preg_split("/\=/", $annotationProperty);
            $annotationPropertiesInstances[] = new AnnotationProperty($splittedAnnotationProperty[0], $splittedAnnotationProperty[1]);
        }
        return $annotationPropertiesInstances;
    }

    /**
     * @param string $docItem
     * @param string $annotationClassString
     * @return AnnotationMetaData[]
     */
    private function getAllAnnotationMetaDataItemsWithProperties(string $docItem, string $annotationClassString) {
        $annotationMetaDataArray = [];
        $annotationProperties = $this->getAllAnnotationPropertiesWithinParentheses($docItem);
        try {
            $annotationComposerClassString = $this->classService->findClassByNamespaceAndClassname(THEWORLDSCMS_NAMESPACE, $annotationClassString);
            $tmpAnnotationMetaData = new AnnotationMetaData($annotationComposerClassString);
            $tmpAnnotationMetaData->setAnnotationProperties($annotationProperties);
            $annotationMetaDataArray[] = $tmpAnnotationMetaData;
        } catch (ClassNotFoundException $e) {
            $e->getMessage();
            die();
        }
        return $annotationMetaDataArray;
    }

    /**
     * @param string $annotationClassString
     * @return AnnotationMetaData[]
     */
    private function getAllAnnotationMetaDataItemsWithoutProperties(string $annotationClassString) {
        $annotationMetaDataArray = [];
        try {
            $annotationComposerClassString = $this->classService->findClassByNamespaceAndClassname(THEWORLDSCMS_NAMESPACE, $annotationClassString);
            $tmpAnnotationMetaData = new AnnotationMetaData($annotationComposerClassString);
            $annotationMetaDataArray[] = $tmpAnnotationMetaData;
        } catch (ClassNotFoundException $e) {
            $e->getMessage();
            die();
        }
        return $annotationMetaDataArray;
    }

    /**
     * @param string $docCommentLine
     * @return Annotation
     */
    private function getAnnotationFromAnnotatedExpressionByDocCommentLine(string $docCommentLine) {
        $tmpClassAnnotation = new Annotation();
        $annotationMetaDataArray = [];
        $annotationClassString = $this->getAnnotationclassstringFromDocCommentLine($docCommentLine);
        if ($this->annotationDefinesAnnotationProperties($docCommentLine)) {
            $annotationMetaDataArray = array_merge($annotationMetaDataArray, $this->getAllAnnotationMetaDataItemsWithProperties($docCommentLine, $annotationClassString));
        } else {
            $annotationMetaDataArray = array_merge($annotationMetaDataArray, $this->getAllAnnotationMetaDataItemsWithoutProperties($annotationClassString));
        }
        $tmpClassAnnotation->setAnnotationsForExpression($annotationMetaDataArray);
        return $tmpClassAnnotation;
    }

    /**
     * @param string $docCommentBlock
     * @return Annotation[]
     */
    private function getAllAnnotationsFromAnnotatedExpression($docCommentBlock) {
        $tmpAnnotationsFromAnnotatedExpression = [];
        $docCommentArray = $this->docCommentToTrimmedStringArray($docCommentBlock, THEWORLDSCMS_ANNOTATION_NAMESPACE);
        foreach ($docCommentArray as $docCommentLine) {
            $tmpAnnotationsFromAnnotatedExpression[] =  $this->getAnnotationFromAnnotatedExpressionByDocCommentLine($docCommentLine);
        }
        return $tmpAnnotationsFromAnnotatedExpression;
    }

}