<?php

namespace TheWorldsCMS\Journey\Composer;

use Composer\Installer\PackageEvent;

class Scripts {
    public static function postUpdateAndInstallCommand(PackageEvent $event) {
        TheWorldsCMS\Utility\debug($event->getName());
    }
    public static function postUpdateAndInstallPackage(PackageEvent $event) {
        TheWorldsCMS\Utility\debug($event->getName());
    }
}