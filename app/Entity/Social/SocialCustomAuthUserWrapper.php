<?php

namespace App\Entity\Social;

use App\Validator\AgeGreaterDiff;
use OrgHeiglHybridAuth\UserInterface;
use SocialConnect\Common\Entity\User;

/**
 * This class works as proxy to the HybridAuth-User-Object
 *
 * @category  HybridAuth
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright ©2012-2013 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     11.01.13
 * @link      https://github.com/heiglandreas/HybridAuth
 */
class SocialCustomAuthUserWrapper implements UserInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the eMail-Address of the user
     *
     * @return string
     */
    public function getAgeRangeMin()
    {
        return $this->user->age_range->min;
    }

    public function getBirthday()
    {
        if ($this->user->birthday) {
            return new \DateTime($this->user->birthday);
        }

        return false;
    }

    public function isAgeSuitalbe()
    {
        $birthday = $this->getBirthday();

        if (!$birthday) {
            return true;
        }

        $validator = new AgeGreaterDiff();
        if ($validator->isValid($birthday)) {
            return true;
        }

        return false;
    }

    /**
     * Get the ID of the user
     *
     * @return string
     */
    public function getUID()
    {
        return $this->user->id;
    }

    /**
     * Get the name of the user
     *
     * @return string
     */
    public function getName()
    {
        return $this->user->username;
    }

    /**
     * Get the eMail-Address of the user
     *
     * @return string
     */
    public function getMail()
    {
        $emails = $this->user->emails[0];
        if ($emails) {
            return $emails->value;
        }

        return $this->user->email;
    }

    /**
     * Get the language of the user
     *
     * @return string
     */
    public function getLanguage()
    {
        return '';
    }

    /**
     * Get the display-name of the user.
     */
    public function getDisplayName()
    {
        if (is_object($this->user->fullname)) {
            return $this->user->fullname->givenName.' '.$this->user->fullname->familyName;
        }

        if ($this->user->fullname) {
            return $this->user->fullname;
        }

        if (! $this->user->firstname && ! $this->user->lastname) {
            return $this->user->username;
        }

        if (! $this->user->firstname) {
            return $this->user->lastname;
        }

        return $this->user->firstname . ' ' . $this->user->lastname;
    }
}
