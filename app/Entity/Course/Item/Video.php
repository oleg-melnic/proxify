<?php
namespace App\Entity\Course\Item;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Video extends ItemAbstract implements S3Interface
{
    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", nullable=false)
     */
    protected $video;

    /**
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param string $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->getVideo();
    }
}
