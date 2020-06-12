<?php



namespace TheWorldsCMS\Journey\Filesystem;
require("./Packages/Application/TheWorldsCMS/Classes/Controller/Abstracts/AbstractController.php");
use TheWorldsCMS\Journey\Annotations as Journey;
use TheWorldsCMS\Packages\Backend\Classes\Controller\Abstracts\AbstractController;

/**
 * Class FilesystemManager
 * @package TheWorldsCMS\Journey\FilesystemManagement
 * @Journey\Singleton()
 */
class FilesystemManager extends AbstractController implements Filesystem {
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