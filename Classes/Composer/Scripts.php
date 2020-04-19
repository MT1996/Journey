<?php

namespace TheWorldsCMS\Journey\Composer;

use TheWorldsCMS\Utility\Utility;

class Scripts {

    public static function postUpdateAndInstallCommand($event) {
        Utility::debug($event);
    }

    public static function postUpdateAndInstallPackage() {

    }

}