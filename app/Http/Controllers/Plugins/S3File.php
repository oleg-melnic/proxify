<?php

namespace App\Controller\Plugins;

use League\Flysystem\Plugin\AbstractPlugin;
use S0mApi\Service\AWS\S3\S3;
use S0mWeb\WTL\File\Transfer\Downloader\Downloader;

class S3File extends AbstractPlugin
{
    /**
     * @var S3
     */
    private $s3Service;

    /**
     * @var Downloader
     */
    private $downloader;

    /**
     * @param $fileInfo
     * @return string
     */
    public function uploadFile($fileInfo)
    {
        $newFile = null;
        if ($fileInfo && $fileInfo['size']) {
            $newFile = $this->getS3Service()->saveFile($fileInfo);
        }

        return $newFile;
    }

    /**
     * @param $fileUrl
     *
     * @return string
     */
    public function downloadFile($fileUrl)
    {
        $newFile = null;
        if ($fileUrl) {
            $newFile = $this->getDownloader()->transferFile($fileUrl);
        }

        return $newFile;
    }

    /**
     * @param string $fileName
     */
    public function deleteFile($fileName)
    {
        $this->getS3Service()->deleteFile($fileName);
    }

    /**
     * @return S3
     */
    private function getS3Service()
    {
        return $this->s3Service;
    }

    /**
     * @param S3 $s3Service
     */
    public function setS3Service(S3 $s3Service)
    {
        $this->s3Service = $s3Service;
    }

    /**
     * @return Downloader
     */
    public function getDownloader(): Downloader
    {
        return $this->downloader;
    }

    /**
     * @param Downloader $downloader
     */
    public function setDownloader(Downloader $downloader)
    {
        $this->downloader = $downloader;
    }

    /**
     * Get the method name.
     *
     * @return string
     */
    public function getMethod()
    {
        // TODO: Implement getMethod() method.
    }
}
