<?php

namespace TheWorldsCMS\Journey\Composer;

use Composer\Installer\PackageEvent;
use function TheWorldsCMS\Journey\Utility\debug;

class Scripts {
    public static function postUpdateAndInstallCommand(PackageEvent $event) {
        debug($event->getName());
    }
    public static function postUpdateAndInstallPackage(PackageEvent $event) {
        debug($event->getName());
    }
}