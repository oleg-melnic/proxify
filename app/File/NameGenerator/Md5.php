<?php
namespace App\File\NameGenerator;

use App\File\NameGenerator\Exception;

/**
 * Class Md5
 * Класс генератора имени файла, использующий Md5 hash.
 */
class Md5 implements GeneratorInterface
{
    /**
     * Базовый путь до директории хранения загруженных файлов
     * @var  string
     */
    protected $basePath;

    /**
     * Глубина вложенности поддиректорий, которые добавляются к основному пути.
     * При значение 3 к основному пути прибавяться еще 3 директории
     * @var  int
     */
    protected $pathDepth;

    /**
     * Метод генерации имени файла.
     * Возвращает имя файла, в которое включена вся необходимая структура директорий.
     *
     * @param string $url     ;
     * @param string $content ;
     *
     * @return string $filename
     *
     * @throws \App\File\NameGenerator\Exception\InvalidParams
     */
    public function generateFileName($url, $content)
    {
        if (!$url || !$content) {
            throw new Exception\InvalidParams;
        }

        //filename and extension  extract from url
        $pathParts = pathinfo(strtok($url, '?'));

        if (isset($pathParts['extension']) && $pathParts['extension']) {
            $extension = $pathParts['extension'];
        } else {
            $extension = end(explode("/", image_type_to_mime_type(exif_imagetype($url))));
        }

        $extension = '.'.$extension;
        $fileName = $this->generateMd5Name($pathParts['filename'], $content, $extension);
        $outPath = $this->generateOutPathByDepth($fileName);
        return $this->getBasePath().$outPath.$fileName;
    }

    /**
     * @param string $origFilename
     * @param string $content
     * @param string $extension - must be (.jpg, .png)
     *
     * @return string
     */
    public function generateMd5Name($origFilename, $content, $extension)
    {
        return md5($origFilename)."_".md5($content).strtolower($extension);
    }

    /**
     * @param string $fileName
     *
     * @return string
     */
    public function generateOutPathByDepth($fileName)
    {
        $charCount = 0;
        $outPath = '';
        $fnChars = str_split($fileName);
        for ($curChar = $charCount; $curChar < $this->getPathDepth(); $curChar++) {
            $outPath .= $fnChars[$curChar]."/";
        }
        return $outPath;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @return int
     */
    public function getPathDepth()
    {
        return $this->pathDepth;
    }

    /**
     * @param int $pathDepth
     */
    public function setPathDepth($pathDepth)
    {
        $this->pathDepth = $pathDepth;
    }
}
