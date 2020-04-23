<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 20:54
 */

namespace TheWorldsCMS\Utility;

define("CONTROLLER_PATH", $_SERVER['DOCUMENT_ROOT'] . "/Classes/");
define("MODEL_PATH", $_SERVER['DOCUMENT_ROOT'] . "/Model/");
define("RESOURCES_PATH", $_SERVER['DOCUMENT_ROOT'] . "/Resources/");
define("UTILITY_PATH", $_SERVER['DOCUMENT_ROOT'] . "/Utility/");
define("CONFIGURATION_PATH", $_SERVER['DOCUMENT_ROOT'] . "/Configuration/");
define("VIEW_PATH", $_SERVER['DOCUMENT_ROOT'] . "/View/");
define("SECTION_PATH", $_SERVER['DOCUMENT_ROOT'] . '/View/HTML/Section/');
define("LAYOUT_PATH", $_SERVER['DOCUMENT_ROOT'] . '/View/HTML/Layout/');
define("TEMPLATE_PATH", $_SERVER['DOCUMENT_ROOT'] . '/View/HTML/Template/');
define("PACKAGES_PATH", $_SERVER['DOCUMENT_ROOT'] . '/Packages/');

class Utility {
    public static function debug($someVariable) {
        echo '<pre>' , var_dump($someVariable) , '</pre><br>';
    }
}