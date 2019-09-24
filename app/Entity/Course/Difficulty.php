<?php
namespace App\Entity\Course;

use App\Entity\Exception\InvalidArgument;
use Doctrine\ORM\Mapping as ORM;
use S0mWeb\WTL\Filter\From\FromScalar\FactoryInterface;

/**
 * @ORM\Embeddable
 */
class Difficulty implements FactoryInterface
{
    const BEGINNER = 'beginner';
    const INTERMEDIATE = 'intermediate';
    const ADVANCED = 'advanced';

    /**
     * @var integer
     *
     * @ORM\Column(name="difficulty", type="string", nullable=true)
     */
    private $difficulty;

    public function __construct($difficulty)
    {
        if (!in_array($difficulty, self::getConstValues())) {
            throw new InvalidArgument("Incorrect difficulty for course: $difficulty");
        }
        $this->difficulty = $difficulty;
    }

    /**
    * @return integer
    */
    public function getValue()
    {
       return $this->difficulty;
    }

    /**
    * @return array
    */
    public static function getConstValues()
    {
        return [self::BEGINNER, self::INTERMEDIATE, self::ADVANCED];
    }

    /**
     * Создаем объект из скалярного значения
     * @param $data
     * @return Difficulty
     */
    public static function createFromScalar($data)
    {
        return new self($data);
    }
}
