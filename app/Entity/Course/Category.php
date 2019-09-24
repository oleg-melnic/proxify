<?php
namespace App\Entity\Course;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use S0mWeb\WTL\Crud\Exception\DeletionFailed;

/**
 * @ORM\Table(name="course_category")
 * @ORM\Entity(repositoryClass="App\Repository\Course\Category")
 */
class Category
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
     * @var CategoryState
     *
     * @ORM\Embedded(class="\App\Entity\Course\CategoryState")
     */
    private $state;

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
     * @return CategoryState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param CategoryState $state
     */
    public function setState(CategoryState $state)
    {
        $this->state = $state;
    }
}
