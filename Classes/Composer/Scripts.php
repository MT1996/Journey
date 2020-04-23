<?php

namespace TheWorldsCMS\Journey\Composer;

use Composer\Package\PackageInterface;
use TheWorldsCMS\Utility\Utility;

class Scripts {
    public static function postUpdateAndInstallCommand(PackageInterface $event) {
        Utility::debug($event->getName());
    }
    public static function postUpdateAndInstallPackage(PackageInterface $event) {
        Utility::debug($event->getName());
    }
}