<?php
namespace App\Entity\Course\Item;

use App\Entity\Exception\InvalidArgument;
use Doctrine\ORM\Mapping as ORM;
use S0mWeb\WTL\Filter\From\FromScalar\FactoryInterface;

/**
 * @ORM\Embeddable
 */
class State implements FactoryInterface
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer", nullable=false)
     */
    private $state;

    /**
     * CategoryState constructor.
     *
     * @param $state
     */
    public function __construct($state)
    {
        if (!in_array($state, self::getConstValues(), true)) {
            throw new InvalidArgument("Incorrect state value: $state");
        }
        $this->state = $state;
    }

    /**
    * @return integer
    */
    public function getState()
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
     * @return State
     */
    public static function createFromScalar($data)
    {
        return new self((int)$data);
    }
}
