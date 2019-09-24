<?php

namespace App\Entity\Subscription;

use App\Entity\ValueObject\Period;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="subscription_package"
 * )
 * @ORM\Entity
 */
class SubscriptionPackage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $identity;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", nullable=false)
     */
    protected $price;

    /**
     * @var Period
     *
     * @ORM\Embedded(class="App\Entity\ValueObject\Period", columnPrefix = false)
     */
    private $period;

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
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * @return Period
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period)
    {
        $this->period = $period;
    }
}
