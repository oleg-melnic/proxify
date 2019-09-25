<?php
namespace App\Entity\User\Social;

use App\Entity\User\UserAbstract;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="social_user")
 * @ORM\Entity()
 */
class User
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
     * @var \App\Entity\User\UserAbstract
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\User\UserAbstract")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \App\Entity\User\Social\Social
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\User\Social\Social")
     * @ORM\JoinColumn(name="social_id", referencedColumnName="id")
     */
    private $social;

    /**
     * @var string
     *
     * @ORM\Column(name="`key`", type="string", nullable=false)
     */
    private $key;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \App\Entity\User\Social\State
     *
     * @ORM\Embedded(class="\App\Entity\User\Social\State")
     */
    private $state;

    public function __construct(UserAbstract $user, Social $social, $key, State $state)
    {
        $this->setUser($user);
        $this->setSocial($social);
        $this->setState($state);
        $this->setKey($key);
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @return UserAbstract
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserAbstract $user
     */
    private function setUser(UserAbstract $user)
    {
        $this->user = $user;
    }

    /**
     * @return Social
     */
    public function getSocial()
    {
        return $this->social;
    }

    /**
     * @param Social $social
     */
    private function setSocial(Social $social)
    {
        $this->social = $social;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    private function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        if (is_null($this->createdAt)) {
            return null;
        }
        return clone $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;
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
}
