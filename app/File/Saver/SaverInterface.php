<?php

namespace App\File\Saver;

/**
 * Interface SaverInterface
 */
interface SaverInterface
{
    /**
     * @param string $filename
     * @param string $content
     * @return string $path
     */
    public function saveToFile($filename, $content);
}
