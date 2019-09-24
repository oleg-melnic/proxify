<?php
namespace App\Entity\Course\Item;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Image extends ItemAbstract implements S3Interface
{
    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", nullable=false)
     */
    protected $image;

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->getImage();
    }
}
