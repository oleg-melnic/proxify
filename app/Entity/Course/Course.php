<?php
namespace App\Entity\Course;

use App\Entity\User\UserAbstract;
use App\Entity\ValueObject\Period;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="courses")
 * @ORM\Entity()
 */
class Course
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @var string
     *
     * @ORM\Column(name="alias", type="string", nullable=false, unique=true)
     */
    private $alias;

    /**
     * The expected period of the course at which it can be considered satisfactory.
     * Example: Expect to require at least 10 hours of study per week to complete this course satisfactorily.
     * @var Period
     *
     * @ORM\Embedded(class="App\Entity\ValueObject\Period", columnPrefix = false)
     */
    private $execution;

    /**
     * Conditions to pass the course at which it can be considered complete.
     * Example: To pass the course, complete all the evaluated issues.
     * @var string
     *
     * @ORM\Column(name="how_pass", type="string", length=250, nullable=true)
     */
    private $howPass;

    /**
     * Difficulty level for course
     * @var Difficulty
     *
     * @ORM\Embedded(class="\App\Entity\Course\Difficulty")
     */
    private $difficulty;

    /**
     * Author of course
     * @var UserAbstract
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\User\UserAbstract")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * Teacher of course
     * @var UserAbstract
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\User\UserAbstract")
     * @ORM\JoinColumn(name="teacher", referencedColumnName="id")
     */
    private $teacher;

    /**
     * Course categories
     * @var Collection|Category[]
     *
     * @ORM\ManyToMany(targetEntity="\App\Entity\Course\Category")
     * @ORM\JoinTable(
     *     name="courses_categories",
     *     joinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    private $categories;

    /**
     * Institution for course
     * @var string
     *
     * @ORM\Column(name="institution", type="text", nullable=true)
     */
    private $institution;

    /**
     * Achieve skills during the course
     * @var string
     *
     * @ORM\Column(name="skills_to_achieve", type="text", nullable=true)
     */
    private $skillsToAchieve;

    /**
     * Course constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
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
     * @param Period $execution
     */
    public function setExecution(Period $execution)
    {
        $this->execution = $execution;
    }

    /**
     * @return Period
     */
    public function getExecution() : Period
    {
        return $this->execution;
    }

    /**
     * @param string $howPass
     */
    public function setHowPass($howPass)
    {
        $this->howPass = $howPass;
    }

    /**
     * @return string
     */
    public function getHowPass()
    {
        return $this->howPass;
    }

    /**
     * @return Difficulty
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param Difficulty $difficulty
     */
    public function setDifficulty(Difficulty $difficulty)
    {
        $this->difficulty = $difficulty;
    }

    /**
     * @return UserAbstract
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param UserAbstract $author
     */
    public function setAuthor(UserAbstract $author)
    {
        $this->author = $author;
    }

    /**
     * @return UserAbstract
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param UserAbstract $teacher
     */
    public function setTeacher(UserAbstract $teacher)
    {
        $this->teacher = $teacher;
    }

    /**
     * Get all categories for course
     *
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add category to course
     *
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        if (!$this->hasCategory($category)) {
            $this->categories->add($category);
        }
    }

    /**
     * Remove course category
     *
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }
    }

    /**
     * @param Category $category
     * @return bool
     */
    public function hasCategory(Category $category)
    {
        return $this->categories->contains($category);
    }

    /**
     * @return string
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * @param string $institution
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;
    }

    /**
     * @return string
     */
    public function getSkillsToAchieve()
    {
        return $this->skillsToAchieve;
    }

    /**
     * @param string $skillsToAchieve
     */
    public function setSkillsToAchieve(string $skillsToAchieve = null)
    {
        $this->skillsToAchieve = $skillsToAchieve;
    }
}
