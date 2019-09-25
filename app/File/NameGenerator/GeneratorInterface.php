<?php

namespace App\File\NameGenerator;

/**
 * Interface GeneratorInterface
 */
interface GeneratorInterface
{
    /**
     * @param string $url
     * @param string $content
     * @return string $filename
     */
    public function generateFileName($url, $content);
}
