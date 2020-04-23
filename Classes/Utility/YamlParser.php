<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 20:48
 */

namespace TheWorldsCMS\Journey\Utility;

use Symfony\Component\Yaml\Yaml;

class YamlParser extends Utility {

    protected $yamlWritingPath = CONFIGURATION_PATH;

    public function __construct() {}

    /**
     * @param string $yamlWritingPath
     * Override des Paths für die YAML-Ausgabe
     */
    public function setYamlWritingPath(string $yamlWritingPath): void {
        $this->yamlWritingPath = $yamlWritingPath;
    }

    /**
     * @return string
     */
    public function getYamlWritingPath(): string {
        return $this->yamlWritingPath;
    }

    /**
     * @param string absoluter Pfad $path
     * geparsetes Array aus einer Yaml-Datei
     * @return array
     */
    public function fileToArray(string $path) {
        return Yaml::parseFile($path);
    }

    /**
     * @param array $settings ist ein PHP-Array
     * parst das PHP-Array in eine YAML-Konfiguration und schreibt diese in eine Datei
     * @param string $fileName
     */
    public function arrayToFile(array $settings, string $fileName) {
        $yamlConfig = Yaml::dump($settings);
        file_put_contents($this->yamlWritingPath . $fileName, $yamlConfig);
    }

    /**
     * Bekommt einen YAML-String als Eingabe und baut ein PHP-Array daraus auf
     * @param string $yamlInput
     * @return mixed
     */
    public function stringToArray(string $yamlInput) {
        return Yaml::parse($yamlInput);
    }
}