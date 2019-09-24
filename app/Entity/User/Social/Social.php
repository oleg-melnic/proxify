<?php

namespace App\Entity\User\Social;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="social")
 * @ORM\Entity
 */
class Social
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
     * @ORM\Column(name="social_name", type="string", length=250, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="social_alias", type="string", length=250, nullable=false, unique=true)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="social_url", type="string", length=250, nullable=false)
     */
    private $url;

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
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $socialAlias
     */
    public function setAlias($socialAlias)
    {
        $this->alias = $socialAlias;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $socialName
     */
    public function setName($socialName)
    {
        $this->name = $socialName;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $socialUrl
     */
    public function setUrl($socialUrl)
    {
        $this->url = $socialUrl;
    }
}
