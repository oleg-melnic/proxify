<?php

namespace App\Entity\Course;

use App\Entity\Exception\InvalidArgument;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class CategoryState
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer", nullable=false)
     */
    private $state;

    public function __construct($state)
    {
        if (!in_array($state, self::getConstValues())) {
            throw new InvalidArgument("Incorrect state for course category: $state");
        }
        $this->state = $state;
    }

    /**
    * @return integer
    */
    public function getValue()
    {
       return $this->state;
    }

    /**
    * @return boolean
    */
    public function isActive()
    {
        if ($this->state==self::ACTIVE) {
            return true;
        }
        return false;
    }

    /**
    * @return array
    */
    public static function getConstValues()
    {
        return [self::ACTIVE, self::INACTIVE];
    }

    /**
     * Создаем объект из скалярного значения
     * @param $data
     * @return object
     */
    public static function createFromScalar($data)
    {
        return new self($data);
    }
}
