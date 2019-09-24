<?php
namespace App\Entity\Subscription;

use App\Entity\User\UserAbstract;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="history_subscription_package"
 * )
 * @ORM\Entity
 */
class HistorySubscriptionPackage
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
     * @ORM\ManyToOne(targetEntity="\App\Entity\User\UserAbstract")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $user;

    /**
     * @var SubscriptionPackage
     * @ORM\ManyToOne(targetEntity="\App\Entity\Subscription\SubscriptionPackage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subscription_package_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $subscriptionPackage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=false)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=false)
     */
    private $endDate;

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return clone $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate)
    {
        if (!is_null($endDate)) {
            $this->endDate = $endDate;
        }
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
        if (!is_null($startDate)) {
            $this->startDate = $startDate;
        }
    }

    /**
     * @return int
     */
    public function getIdentity(): int
    {
        return $this->identity;
    }

    /**
     * Get related student
     *
     * @return UserAbstract
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserAbstract $user
     */
    public function setUser(UserAbstract $user)
    {
        $this->user = $user;
    }

    /**
     * @return SubscriptionPackage
     */
    public function getSubscriptionPackage()
    {
        return $this->subscriptionPackage;
    }

    /**
     * @param SubscriptionPackage $subscriptionPackage
     */
    public function setSubscriptionPackage(SubscriptionPackage $subscriptionPackage)
    {
        $this->subscriptionPackage = $subscriptionPackage;
    }
}
