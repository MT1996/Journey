<?php


namespace TheWorldsCMS\Journey\Filesystem;


interface Filesystem {

    public function createDirectory($directory);
    public function createDirectories($directories);
    public function directoryContainsSubDirectory($subDirectory);
    public function createFile($file);
    public function createFiles($files);
    public function filenameIsDirectory($filename);
    public function removeDirectory($directory);

}