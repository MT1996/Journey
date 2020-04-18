<?php
namespace TheWorldsCMS\Journey\Core;

use Composer\Autoload\ClassLoader;
use TheWorldsCMS\Journey\AnnotationEngine\AnnotationManager;
use TheWorldsCMS\Journey\AnnotationEngine\AnnotationService;
use TheWorldsCMS\Journey\ClassService;

/**
 * Class Bootstrap
 * @package TheWorldsCMS\Packages\Journey\Classes\Core
 */
class Bootstrap {

    /**
     * @var ClassLoader
     */
    protected $classLoader;

    /**
     * @var string
     */
    protected $context;

    /**
     * Bootstrap constructor.
     * @param ClassLoader $classLoader
     * @param string $context
     */
    public function __construct(ClassLoader $classLoader, string $context) {
        $this->classLoader = $classLoader;
        $this->context = $context;
    }

    /**
     * Entry-Point des CMS, das erst auf das Framework draufgeht
     */
    public function run() {
        $this->prepareBeforeActualRunning();
    }

    /**
     * Diese Funktion soll alle Konstanten, die dieses Framework verwendet zuerst deklarieren
     * und mit Hilfe der eigenen Annotationengine alle Annotationen der Klassen und Properties erkennen
     * und so den Code in der Semantik mit zusätzlicher Logik anreichern (Einmalige Singleton Definition mit Closures usw.)
     */
    private function prepareBeforeActualRunning() {
        $this->declareAllConstants();
        $classService = new ClassService($this->classLoader);
        $annotationService = new AnnotationService($classService);
        $annotationManager = new AnnotationManager($classService, $annotationService);
        $annotationManager->enhanceClassesWithAnnotations();
    }

    /**
     * Deklariert alle Funktionen, die jemals verwendet werden sollen
     */
    public function declareAllConstants() {
        if (!defined("THEWORLDSCMS_NAMESPACE")) define("THEWORLDSCMS_NAMESPACE", "TheWorldsCMS");
        if (!defined("THEWORLDSCMS_DEFAULT_ANNOTATION_FUNCTION")) define("THEWORLDSCMS_DEFAULT_ANNOTATION_FUNCTION", "annotate");
        if (!defined("THEWORLDSCMS_ALL_CLASSES")) define("THEWORLDSCMS_ALL_CLASSES", "*");
        if (!defined("THEWORLDSCMS_ANNOTATION_NAMESPACE")) define("THEWORLDSCMS_ANNOTATION_NAMESPACE", "Journey");
        if (!defined("THEWORLDSCMS_CLASSANNOTATION_STRING")) define("THEWORLDSCMS_CLASSANNOTATION_STRING", "ClassAnnotations");
        if (!defined("THEWORLDSCMS_PROPERTYANNOTATION_STRING")) define("THEWORLDSCMS_PROPERTYANNOTATION_STRING", "PropertyAnnotations");
    }
}