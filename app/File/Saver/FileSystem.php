<?php

namespace App\File\Saver;

use App\File\Saver\Exception;

/**
 * Class FileSystem
 * Класс Saver'a реализованный как адаптер на Symfony FileSystem
 */
class FileSystem implements SaverInterface
{
    /** @var  \Illuminate\Filesystem\Filesystem() */
    protected $fileSystem;

    /**
     * @param string $filename
     * @param string $content
     *
     * @return string $path
     *
     * @throws \App\File\Saver\Exception\CannotSaveFile
     */
    public function saveToFile($filename, $content)
    {
        try {
            $this->getFileSystem()->append($filename, $content);
        } catch (\Exception $e) {
            throw new Exception\CannotSaveFile($e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFileSystem()
    {
        if (is_null($this->fileSystem)) {
            $this->setFileSystem(new \Illuminate\Filesystem\Filesystem());
        }

        return $this->fileSystem;
    }

    /**
     * @param \Illuminate\Filesystem\Filesystem()
     */
    public function setFileSystem($fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }
}
