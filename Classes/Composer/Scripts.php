<?php

namespace TheWorldsCMS\Journey\Composer;

use Composer\Installer\PackageEvent;
use TheWorldsCMS\Journey\Utility\Utility;

class Scripts {
    public static function postUpdateAndInstallCommand(PackageEvent $event) {
        Utility::debug("------------------------------------------------------------------");
        Utility::debug($event->getName());
        Utility::debug("------------------------------------------------------------------");
    }
    public static function postUpdateAndInstallPackage(PackageEvent $event) {
        Utility::debug("------------------------------------------------------------------");
        Utility::debug($event->getName());
        Utility::debug("------------------------------------------------------------------");
    }
}