<?php
namespace App\Entity\Course;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use S0mWeb\WTL\Crud\Exception\DeletionFailed;

/**
 * @ORM\Table(name="course_chapter")
 * @ORM\Entity(repositoryClass="App\Repository\Course\Chapter")
 */
class Chapter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $identity;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @var string
     *
     * @ORM\Column(name="alias", type="string", nullable=false, unique=true)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=true)
     */
    private $description;

    /**
     * @var State
     *
     * @ORM\Embedded(class="\App\Entity\Course\ChapterState")
     */
    private $state;

    /**
     * @var Course
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Course\Course")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;

    /**
     * @Gedmo\Sortable(groups={"course"})
     * @var integer
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position;

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
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
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
     * @return ChapterState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param ChapterState $state
     */
    public function setState(ChapterState $state)
    {
        $this->state = $state;
    }

    /**
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param Course $course
     */
    public function setCourse(Course $course)
    {
        $this->course = $course;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
