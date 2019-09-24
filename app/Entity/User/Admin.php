<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Admin extends UserAbstract
{
    /**
     * Get a list of role names
     *
     * @return array
     */
    protected function getRoleNames()
    {
        return ['admin'];
    }
}
