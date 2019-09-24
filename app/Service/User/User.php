<?php
namespace App\Service\User;

use App\Entity\User\Admin;
use App\Entity\User\Professor;
use App\Entity\User\Student;
use App\Service\Mail\User\MailService;
use App\Service\User\Strategy\UserAbstract;
use CirclicalUser\Service\AuthenticationService;
use Doctrine\ORM\EntityRepository;
use S0mWeb\WTL\Crud\CrudInterface;
use S0mWeb\WTL\Crud\CrudTrait;
use S0mWeb\WTL\Crud\Inheritance\Inheritance;
use S0mWeb\WTL\Crud\InheritanceAwareInterface;
use S0mWeb\WTL\Crud\InheritanceAwareTrait;
use S0mWeb\WTL\StdLib\EntityManagerAwareInterface;
use S0mWeb\WTL\StdLib\EntityManagerAwareTrait;
use Zend\Math\Rand;

/**
 * Class User
 * @method Inheritance getInheritanceResolver()
 */
class User implements CrudInterface, InheritanceAwareInterface, EntityManagerAwareInterface
{
    use CrudTrait;
    use InheritanceAwareTrait;
    use EntityManagerAwareTrait;

    const TYPE_ADMIN = 'admin';
    const TYPE_STUDENT = 'student';
    const TYPE_PROFESSOR = 'professor';

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\User\UserAbstract::class;
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getInheritanceResolver()->getRepository();
    }

    /**
     * @param $type
     *
     * @return UserAbstract
     */
    private function getStrategy($type)
    {
        return $this->getInheritanceResolver()->getStrategy($type);
    }

    /**
     * Получить название поля являющееся разделителем inheritance
     *
     * @return string
     */
    public function getDiscriminatorName()
    {
        return 'type';
    }

    /**
     * Получить список поддерживаемых серверов.
     *
     * формат: [
     *   '<имя из сущности>' => '<имя сервиса>'
     * ]
     *
     * @return array
     */
    public function getServicesNames()
    {
        return [
            self::TYPE_ADMIN => \App\Service\User\Strategy\Admin::class,
            self::TYPE_STUDENT => \App\Service\User\Strategy\Student::class,
            self::TYPE_PROFESSOR => \App\Service\User\Strategy\Professor::class,
        ];
    }

    /**
     * @param array $data
     *
     * @param bool $flush
     * @param array $context
     * @param string $permission
     *
     * @return object
     * @throws \Exception
     */
    public function create(array $data, $flush = true, array $context = [], $permission = __FUNCTION__)
    {
        $this->getEntityManager()->beginTransaction();
        $context['identity'] = '';
        try {
            $entity = $this->getInheritanceResolver()->create($data, $flush, $context, $permission);
            $this->getEntityManager()->commit();
        } catch (\Exception $exception) {
            $this->getEntityManager()->rollback();
            throw $exception;
        }

        return $entity;
    }

    /**
     * @return AuthenticationService
     */
    private function getAuthenticationService()
    {
        return $this->authenticationService;
    }

    /**
     * @param AuthenticationService $authenticationService
     */
    public function setAuthenticationService($authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @param string $email
     * @return \App\Entity\User\UserAbstract
     */
    public function getEntityByEmail($email)
    {
        return $this->getRepository()->findOneByEmail($email);
    }

    /**
     * @return MailService
     */
    public function getMailService()
    {
        return $this->mailService;
    }

    /**
     * @param MailService $mailService
     */
    public function setMailService($mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @param array $params
     * @return \App\Entity\User\UserAbstract|null
     *
     */
    public function getOne(array $params)
    {
        return $this->getRepository()->findOneBy($params);
    }

    /**
     * Generates a password reset token for the user. This token is then stored in database and
     * sent to the user's E-mail address. When the user clicks the link in E-mail message, he is
     * directed to the Set Password page.
     */
    public function generatePasswordResetToken($user)
    {
        // Generate a token.
        $token = Rand::getString(32, '0123456789abcdefghijklmnopqrstuvwxyz', true);
        $user->setPasswordResetToken($token);

        $currentDate = new \DateTime("now");
        $user->setPasswordResetTokenCreationDate($currentDate);

        $this->getEntityManager()->flush();
        $data = [
            "token" => $token,
            "email" => $user->getEmail()
        ];
        $this->getMailService()->resetPasswordEmail($data);
    }

    /**
     * Checks whether the given password reset token is a valid one.
     */
    public function validatePasswordResetToken($passwordResetToken)
    {
        $user = $this->getRepository()
            ->findOneBy(['passwordResetToken' => $passwordResetToken]);

        if($user==null) {
            return false;
        }

        $tokenCreationDate = $user->getPasswordResetTokenCreationDate()->getTimestamp();
        $currentDate = strtotime('now');

        if ($currentDate - $tokenCreationDate > 24*60*60) {
            return false; // expired
        }

        return true;
    }

    /**
     * This method sets new password by password reset token.
     */
    public function setNewPasswordByToken($passwordResetToken, $newPassword)
    {
        if (!$this->validatePasswordResetToken($passwordResetToken)) {
            return false;
        }

        $user = $this->getRepository()
            ->findOneByPasswordResetToken($passwordResetToken);

        if ($user==null) {
            return false;
        }

        // Set new password for user
        $this->authenticationService->resetPassword($user, $newPassword);

        // Remove password reset token
        $user->setPasswordResetToken(null);
        $user->setPasswordResetTokenCreationDate(null);

        $this->entityManager->flush();

        return true;
    }

    /**
     * Subscribe to offline event
     *
     * @param \App\Service\Event\Offline $event
     * @return boolean
     */
    public function subscribeOfflineEvent($event, $userId)
    {
        $user = $this->getRepository()->findOneByIdentity($userId);
        if ($user==null) {
            return false;
        }
        $user->addOfflineEvent($event);
        $this->getEntityManager()->flush();
        return true;
    }

    /**
     * Unsubscribe to offline event
     *
     * @param array $data
     */
    public function unsubscribeOfflineEvent($event, $userId)
    {
        $user = $this->getRepository()->findOneByIdentity($userId);
        if ($user==null) {
            return false;
        }
        $user->removeOfflineEvent($event);
        $this->getEntityManager()->flush();
        return true;
    }

    /**
     * Get list of users for offline event
     *
     * @param integer $eventId
     * @param integer $exceptUserId
     * @return UserAbstract $usersList
     */
    public function getUsersByOfflineEvents($eventId, $exceptUserId=null)
    {
        $usersList = $this->getRepository()->getUsersByOfflineEvents($eventId, $exceptUserId);
        return $usersList;
    }

    /**
     * Get list of users for offline event
     *
     * @param integer $eventId
     * @param integer $userId
     * @return UserAbstract $usersList
     */
    public function isSubscribedToOfflineEvent($eventId, $userId)
    {
        $usersList = $this->getRepository()->isSubscribedToOfflineEvent($eventId, $userId);
        return $usersList;
    }

    /**
     * @return \App\Entity\User\UserAbstract[]|null
     */
    public function getAllUsers()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param \App\Entity\User\UserAbstract $user
     * @return string
     */
    public function getUserType($user)
    {
        if ($user instanceof Student) {
            return "student";
        } elseif ($user instanceof Professor) {
            return "professor";
        } elseif ($user instanceof Admin) {
            return "admin";
        }
    }

    /**
     * Create new user
     *
     * @param array $data
     * @return \App\Entity\User\UserAbstract
     */
    public function createNew(array $data)
    {
        /** @var UserAbstract $strategy */
        $strategy = $this->getInheritanceResolver()->getStrategy($data['type']);
        return $strategy->createNew($data);
    }

    /**
     * Change user data
     *
     * @param int   $identity
     * @param array $data
     *
     * @return \App\Entity\User\UserAbstract
     */
    public function changeData($identity, array $data)
    {
        /** @var UserAbstract $strategy */
        $strategy = $this->getInheritanceResolver()->getStrategyByIdentity($identity);
        return $strategy->changeData($identity, $data);
    }

    /**
     * @param $type
     * @return \App\Entity\User\UserAbstract[]|null
     */
    public function getAll($type)
    {
        return $this->getStrategy($type)->getAll();
    }

    /**
     * Change user password
     *
     * @param \App\Entity\User\UserAbstract $user
     * @param array $data
     *
     * @return boolean|array
     */
    public function changePassword($user, array $data)
    {
        /** @var UserAbstract $strategy */
        $strategy = $this->getInheritanceResolver()->getStrategyByIdentity($user->getIdentity());
        return $strategy->changePassword($user, $data);
    }

    /**
     * Delete user account
     *
     * @param \App\Entity\User\UserAbstract $user
     * @param array $data
     *
     * @return boolean|array
     */
    public function deleteAccount($user, array $data)
    {
        /** @var UserAbstract $strategy */
        $strategy = $this->getInheritanceResolver()->getStrategyByIdentity($user->getIdentity());
        return $strategy->deleteAccount($user, $data);
    }

    /**
     * Save user avatar
     *
     * @param int   $identity
     * @param array $data
     *
     * @return \App\Entity\User\UserAbstract
     */
    public function saveAvatar($identity, array $data)
    {
        /** @var UserAbstract $strategy */
        $strategy = $this->getInheritanceResolver()->getStrategyByIdentity($identity);
        return $strategy->saveAvatar($identity, $data);
    }
}
