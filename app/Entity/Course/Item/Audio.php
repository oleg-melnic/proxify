<?php
namespace App\Entity\Course\Item;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Audio extends ItemAbstract implements S3Interface
{
    /**
     * @var string
     *
     * @ORM\Column(name="audio", type="string", nullable=false)
     */
    protected $audio;

    /**
     * @return string
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * @param string $audio
     */
    public function setAudio($audio)
    {
        $this->audio = $audio;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->getAudio();
    }
}
