<?php
namespace App\Entity\Course\Item;

use App\Entity\Course\Chapter;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="course_item")
 * @ORM\Entity(repositoryClass="App\Repository\Course\Item")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *         "article" = "Article",
 *         "video" = "Video",
 *         "audio" = "Audio",
 *         "quiz" = "Quiz",
 *         "document" = "Document",
 *         "image" = "Image",
 *     }
 * )
 */
abstract class ItemAbstract
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $identity;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @var string
     *
     * @ORM\Column(name="alias", type="string", nullable=false, unique=true)
     */
    protected $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="free", type="boolean", nullable=false)
     */
    protected $isFree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=false)
     */
    protected $startDate;

    /**
     * @var State
     *
     * @ORM\Embedded(class="\App\Entity\Course\Item\State", columnPrefix = false)
     */
    protected $state;

    /**
     * @var Chapter
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Course\Chapter")
     * @ORM\JoinColumn(name="chapter_id", referencedColumnName="id")
     */
    private $chapter;

    /**
     * ItemAbstract constructor.
     */
    public function __construct()
    {
        $this->setStartDate(new \DateTime());
        $this->setState(State::createFromScalar(State::INACTIVE));
    }

    /**
     * @return int
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return boolean
     */
    public function isFree()
    {
        return $this->isFree;
    }

    /**
     * @param boolean $free
     */
    public function setIsFree($free)
    {
        $this->isFree = $free;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return clone $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = clone $startDate;
    }

    /**
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param State $state
     */
    public function setState(State $state)
    {
        $this->state = $state;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->getState()->isActive();
    }

    /**
     * @return Chapter
     */
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * @param Chapter $chapter
     */
    public function setChapter(Chapter $chapter)
    {
        $this->chapter = $chapter;
    }
}
