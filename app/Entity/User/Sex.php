<?php

namespace App\Entity\User;

use App\Entity\Exception\InvalidArgument;
use Doctrine\ORM\Mapping as ORM;
use S0mWeb\WTL\Filter\From\FromScalar\FactoryInterface;

/**
 * @ORM\Embeddable
 */
class Sex implements FactoryInterface
{
    const FEMALE = 'w';
    const MALE = 'm';

    /**
     * @var String
     *
     * @ORM\Column(name="sex", type="string", length=1, nullable=true, options={"fixed": true})
     */
    private $sex;

    public function __construct($sex)
    {
        if (!in_array($sex, $this->getConstValues())) {
            throw new InvalidArgument('Не верный пол');
        }

        $this->sex = $sex;
    }

    /**
     * Создаем объект из скалярного значения
     *
     * @param $data
     *
     * @return Sex
     */
    public static function createFromScalar($data)
    {
        return new self($data);
    }

    /**
     * @return array
     */
    public function getConstValues()
    {
        return [
            self::MALE,
            self::FEMALE
        ];
    }

    /**
     * @return String
     */
    public function getValue()
    {
        return $this->sex;
    }

    /**
     * Мужской пол?
     * @return bool
     */
    public function isMale()
    {
        return $this->getValue() === self::MALE;
    }

    /**
     * Женский пол?
     * @return bool
     */
    public function isFemale()
    {
        return $this->getValue() === self::FEMALE;
    }
}
