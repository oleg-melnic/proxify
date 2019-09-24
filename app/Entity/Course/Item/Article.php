<?php
namespace App\Entity\Course\Item;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Article extends ItemAbstract
{
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    protected $content;

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
