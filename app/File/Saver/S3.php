<?php
namespace App\File\Saver;

use S0mWeb\WTL\File\Saver\SaverInterface;

class S3 implements SaverInterface
{
    /**
     * @var \S0mApi\Service\AWS\S3\S3
     */
    private $s3Service;

    /**
     * @return \S0mApi\Service\AWS\S3\S3
     */
    public function getS3Service(): \S0mApi\Service\AWS\S3\S3
    {
        return $this->s3Service;
    }

    /**
     * @param \S0mApi\Service\AWS\S3\S3 $s3Service
     */
    public function setS3Service(\S0mApi\Service\AWS\S3\S3 $s3Service)
    {
        $this->s3Service = $s3Service;
    }

    /**
     * @param string $filename
     * @param string $content
     *
     * @return string $path
     */
    public function saveToFile($filename, $content)
    {
        $this->getS3Service()->saveContent($filename, $content);

        return $filename;
    }
}
