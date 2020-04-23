<?php

namespace TheWorldsCMS\Journey\Composer;

use Composer\Installer\PackageEvent;
use TheWorldsCMS\Utility\Utility;

class Scripts {
    public static function postUpdateAndInstallCommand(PackageEvent $event) {
        Utility::debug($event->getName());
    }
    public static function postUpdateAndInstallPackage(PackageEvent $event) {
        Utility::debug($event->getName());
    }
}