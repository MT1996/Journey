<?php

namespace TheWorldsCMS\Journey\Package;

use TheWorldsCMS\Journey\Annotations as Journey;
use TheWorldsCMS\Journey\Filesystem\FilesystemManager;

/**
 * Class PackageManager
 * @package TheWorldsCMS\Journey\PackageManagement
 * @Journey\Singleton()
 */
class PackageManager {

    /**
     * @var FilesystemManager
     * @Journey\Injection(FilesystemManager)
     */
    protected $filesystemManager;

}