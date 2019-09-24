<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Student extends UserAbstract
{
    /**
     * Get a list of role names
     *
     * @return array
     */
    protected function getRoleNames()
    {
        return ['student'];
    }
}
