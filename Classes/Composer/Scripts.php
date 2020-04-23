<?php

namespace TheWorldsCMS\Journey\Composer;

use Composer\Installer\PackageEvent;
use function TheWorldsCMS\Journey\Utility\debug;

class Scripts {
    public static function postUpdateAndInstallCommand(PackageEvent $event) {
        debug("------------------------------------------------------------------");
        debug($event->getName());
        debug("------------------------------------------------------------------");
    }
    public static function postUpdateAndInstallPackage(PackageEvent $event) {
        debug("------------------------------------------------------------------");
        debug($event->getName());
        debug("------------------------------------------------------------------");
    }
}