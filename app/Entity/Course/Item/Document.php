<?php
namespace App\Entity\Course\Item;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Document extends ItemAbstract implements S3Interface
{
    /**
     * @var string
     *
     * @ORM\Column(name="document", type="string", nullable=false)
     */
    protected $document;

    /**
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param string $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->getDocument();
    }
}
