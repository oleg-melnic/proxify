<?php

namespace App\Entity\User;

use App\Entity\Event\Offline as OfflineEvent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="users"
 * )
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"admin" = "Admin", "student" = "Student", "professor" = "Professor"})
 *
 */
abstract class UserAbstract
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
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=250, nullable=true)
     */
    private $fullName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="datetime", nullable=true)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=250, nullable=true)
     */
    private $address;

    /**
     * @var Sex
     *
     * @ORM\Embedded(class="\App\Entity\User\Sex", columnPrefix=false)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="timezone", type="string", length=50, nullable=true)
     */
    private $timezone;

    /**
     * @var State
     *
     * @ORM\Embedded(class="\App\Entity\User\State")
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd_reset_token", type="string", length=32, nullable=true)
     */
    protected $passwordResetToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pwd_reset_token_creation_date", type="datetime", nullable=true)
     */
    protected $passwordResetTokenCreationDate;

    /**
     * @var Collection|OfflineEvent[]
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Event\Offline")
     * @ORM\JoinTable(
     *     name="users_offline_events",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="offline_event_id", referencedColumnName="id")}
     * )
     */
    private $offlineEvents;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->offlineEvents = new ArrayCollection();
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        if (is_null($this->birthday)) {
            return null;
        }
        return clone $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday(\DateTime $birthday = null)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return Sex
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param Sex $sex
     */
    public function setSex(Sex $sex = null)
    {
        $this->sex = $sex;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
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
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param State $state
     */
    public function setState(State $state)
    {
        $this->state = $state;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->state->isActive();
    }

    /**
     * Returns password reset token.
     * @return string
     */
    public function getResetPasswordToken()
    {
        return $this->passwordResetToken;
    }

    /**
     * Sets password reset token.
     * @param string $token
     */
    public function setPasswordResetToken($token)
    {
        $this->passwordResetToken = $token;
    }

    /**
     * Returns password reset token's creation date.
     * @return \DateTime
     */
    public function getPasswordResetTokenCreationDate()
    {
        return $this->passwordResetTokenCreationDate;
    }

    /**
     * Sets password reset token's creation date.
     * @param string $date
     */
    public function setPasswordResetTokenCreationDate(\DateTime $date=null)
    {
        $this->passwordResetTokenCreationDate = $date;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getIdentity();
    }

    /**
     * Get a list of role names
     *
     * @return array
     */
    protected abstract function getRoleNames();

    /**
     * Get all offline events for user
     *
     * @return ArrayCollection
     */
    public function getOfflineEvents()
    {
        return $this->offlineEvents;
    }

    /**
     * Add offline event to user
     *
     * @param \App\Entity\Event\Offline $offlineEvent
     */
    public function addOfflineEvent(OfflineEvent $offlineEvent)
    {
        $this->offlineEvents->add($offlineEvent);
    }

    /**
     * Remove offline event from user
     *
     * @param \App\Entity\Event\Offline $offlineEvent
     */
    public function removeOfflineEvent(OfflineEvent $offlineEvent)
    {
        if ($this->offlineEvents->contains($offlineEvent)) {
            $this->offlineEvents->removeElement($offlineEvent);
        }
    }
}
