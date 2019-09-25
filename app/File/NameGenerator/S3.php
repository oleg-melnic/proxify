<?php

namespace App\File\NameGenerator;

use Symfony\Component\Mime\MimeTypes;

class S3 implements GeneratorInterface
{
    /**
     * @var array
     */
    private $directories;

    /**
     * @param $type
     * @return MimeTypes
     */
    public function getMimeTypeValidator($type)
    {
        return new MimeTypes($type);
    }

    /**
     * @return array
     */
    public function getDirectories(): array
    {
        return $this->directories;
    }

    /**
     * @param array $directories
     */
    public function setDirectories(array $directories)
    {
        $this->directories = $directories;
    }

    /**
     * @param string $url
     * @param string $content
     *
     * @return string $filename
     */
    public function generateFileName($url, $content)
    {
        $temp = tmpfile();
        fwrite($temp, $content);
        fseek($temp, 0);
        $fileName = stream_get_meta_data($temp)['uri'];

        $directory = 'docs/';
        foreach ($this->getDirectories() as $type => $dir) {
            if ($this->getMimeTypeValidator([$type])->isValid($fileName)) {
                $directory = $dir;
            }
        }
        fclose($temp);

        return $directory . md5($url);
    }
}
