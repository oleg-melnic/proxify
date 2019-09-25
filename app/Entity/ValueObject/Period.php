<?php

namespace App\Entity\ValueObject;

use App\Entity\Exception\InvalidArgument;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Period
{
    const PERIOD_ONE_YEAR = 'P1Y';
    const PERIOD_HALF_YEAR = 'P6M';
    const PERIOD_THREE_MONTH = 'P3M';
    const PERIOD_ONE_MONTH = 'P1M';

    /**
     * @var \DateInterval
     */
    protected $dateInterval;

    /**
     * @var String
     *
     * @ORM\Column(name="period", type="string", length=20, nullable=true, options={"fixed": true})
     */
    protected $period;

    /**
     * Period constructor.
     * @param String $dateInterval
     */
    public function __construct($dateInterval)
    {
        if (!in_array($dateInterval, self::getConstValues())) {
            throw new InvalidArgument('Value is not valid');
        }

        $this->dateInterval = new \DateInterval($dateInterval);
        $this->period = $dateInterval;
    }

    /**
     * @return \DateInterval
     */
    protected function getDateInterval(): \DateInterval
    {
        return $this->dateInterval;
    }

    /**
     * @param \DateInterval $dateInterval
     */
    protected function setDateInterval(\DateInterval $dateInterval)
    {
        $this->dateInterval = $dateInterval;
    }

    /**
     * @return void
     */
    private function initDateInterval()
    {
        $this->setDateInterval(new \DateInterval($this->period));
    }

    /**
     * Создаем объект из скалярного значения
     * @param $data
     * @return Period
     */
    public static function createFromScalar($data)
    {
        return new self($data);
    }

    /**
     * @param DateTime $startDate
     *
     * @return DateTime
     */
    public function getEndDate(DateTime $startDate)
    {
        if (is_null($this->getDateInterval())) {
            $this->initDateInterval();
        }
        $date = clone $startDate;

        return $date->add($this->getDateInterval());
    }

    /**
     * @return array
     */
    public static function getConstValues()
    {
        return [
            self::PERIOD_ONE_YEAR,
            self::PERIOD_HALF_YEAR,
            self::PERIOD_THREE_MONTH,
            self::PERIOD_ONE_MONTH,
        ];
    }

    /**
     * @return String
     */
    public function getValue()
    {
        return $this->period;
    }
}
