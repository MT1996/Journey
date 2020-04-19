<?php


namespace TheWorldsCMS\Journey\Filesystem;

use TheWorldsCMS\Journey\Annotations as Journey;

/**
 * Class FilesystemManager
 * @package TheWorldsCMS\Journey\FilesystemManagement
 * @Journey\Singleton()
 */
class FilesystemManager implements Filesystem {
    /**
     * @var string
     */
    protected $currentDirectory;

    /**
     * @param string $directory
     */
    public function createDirectory($directory) {
        // TODO: Implement createDirectory() method.
    }

    /**
     * @param string[] $directories
     */
    public function createDirectories($directories) {
        // TODO: Implement createDirectories() method.
    }

    /**
     * @param string $subDirectory
     */
    public function directoryContainsSubDirectory($subDirectory) {
        // TODO: Implement directoryContainsSubDirectory() method.
    }

    /**
     * @param string $file
     */
    public function createFile($file) {
        // TODO: Implement createFile() method.
    }

    /**
     * @param string[] $files
     */
    public function createFiles($files) {
        // TODO: Implement createFiles() method.
    }

    /**
     * @param string $filename
     */
    public function filenameIsDirectory($filename) {
        // TODO: Implement filenameIsDirectory() method.
    }

    /**
     * @param string $currentDirectory
     */
    public function setCurrentDirectory($currentDirectory) {
        $this->currentDirectory = $currentDirectory;
    }

    /**
     * @param string $directory
     */
    public function removeDirectory($directory) {
        // TODO: Implement removeDirectory() method.
    }
}