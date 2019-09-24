<?php
/**
 * Main User Service serving for base link to Admin/Student/Professor Services
 *
 * @author Олег Мельник
 */

namespace App\Service\User\Strategy;

use CirclicalUser\Provider\RoleProviderInterface;
use CirclicalUser\Service\AuthenticationService;
use S0mWeb\WTL\Crud\CrudInterface;
use S0mWeb\WTL\Crud\Helper\DeleteTrait;
use S0mWeb\WTL\Crud\Helper\ReadTrait;
use S0mWeb\WTL\Crud\Helper\UpdateTrait;
use S0mWeb\WTL\Crud\NoInheritanceAwareInterface;
use S0mWeb\WTL\Crud\NoInheritanceAwareTrait;
use S0mWeb\WTL\StdLib\EntityManagerAwareInterface;
use S0mWeb\WTL\StdLib\EntityManagerAwareTrait;
use S0mWeb\WTL\StdLib\ServiceLocatorAwareInterface;
use S0mWeb\WTL\StdLib\ServiceLocatorAwareTrait;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class UserAbstract
 * @package App\Service\User\Strategy
 */
abstract class UserAbstract implements
    CrudInterface,
    NoInheritanceAwareInterface,
    EntityManagerAwareInterface
{
    use NoInheritanceAwareTrait;
    use UpdateTrait;
    use DeleteTrait;
    use ReadTrait;
    use EntityManagerAwareTrait;

    /**
     * @var RoleProviderInterface
     */
    private $roleProvider;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    protected function getRepository()
    {
        return $this->getInheritanceResolver()->getRepository();
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
            $this->getAuthenticationService()->registerAuthenticationRecord(
                $entity,
                $entity->getEmail(),
                $data['password']
            );
            $this->getEntityManager()->commit();
        } catch (\Exception $exception) {
            $this->getEntityManager()->rollback();
            throw $exception;
        }

        return $entity;
    }

    /**
     * @return RoleProviderInterface
     */
    public function getRoleProvider()
    {
        return $this->roleProvider;
    }

    /**
     * @param RoleProviderInterface $roleProvider
     */
    public function setRoleProvider($roleProvider)
    {
        $this->roleProvider = $roleProvider;
    }

    /**
     * @return AuthenticationService
     */
    public function getAuthenticationService()
    {
        return $this->authenticationService;
    }

    /**
     * @param AuthenticationService $authenticationService
     */
    public function setAuthenticationService(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * Change user password
     *
     * @param  \App\Entity\User\UserAbstract $user
     * @param array $data
     *
     * @return boolean|array
     */
    public function changePassword($user, array $data)
    {
        $newPassword = $data['new_password'];
        // Set new password for user
        $this->getAuthenticationService()->resetPassword($user, $newPassword);
        $this->getAuthenticationService()->authenticate($user->getEmail(), $newPassword);
        $this->entityManager->flush();

        return true;
    }

    /**
     * Create new user
     *
     * @param array $data
     * @return \App\Entity\User\UserAbstract
     */
    public function createNew(array $data)
    {
        $this->getInheritanceResolver()->getFilter()->setValidationGroup(
            ['email', 'fullName', 'password', 'state', 'birthday', 'address', 'timezone', 'sex', 'state']
        );

        try {
            $result = $this->create($data, true, [], __FUNCTION__);
        } catch (\S0mWeb\WTL\Crud\Exception\ValidationException $e) {
            return ['errors' => $e->getValidationMessages()];
        }

        $this->getInheritanceResolver()->getFilter()->setValidationGroup(InputFilterInterface::VALIDATE_ALL);

        return $result;
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
        $this->getInheritanceResolver()->getFilter()->setValidationGroup(
            ['email', 'fullName', 'state', 'birthday', 'address', 'timezone', 'sex', 'state', 'description']
        );

        try {
            $result = $this->update($identity, $data);
        } catch (\S0mWeb\WTL\Crud\Exception\ValidationException $e) {
            return ['errors' => $e->getValidationMessages()];
        }

        $this->getInheritanceResolver()->getFilter()->setValidationGroup(InputFilterInterface::VALIDATE_ALL);

        return $result;
    }

    /**
     * @return \App\Entity\User\UserAbstract[]|null
     */
    abstract public function getAll();

    /**
     * Change user password
     *
     * @param  \App\Entity\User\UserAbstract $user
     * @param array $data
     *
     * @return boolean|array
     */
    public function deleteAccount($user, array $data)
    {
        $this->getInheritanceResolver()->getFilter()->setValidationGroup(
            ['state']
        );

        try {
            $this->getInheritanceResolver()->validate($data, null, []);
            $this->update($user->getIdentity(), $data);
            $this->getAuthenticationService()->clearIdentity();
        } catch (\S0mWeb\WTL\Crud\Exception\ValidationException $e) {
            return ['errors' => $e->getValidationMessages()];
        }

        $this->getInheritanceResolver()->getFilter()->setValidationGroup(InputFilterInterface::VALIDATE_ALL);

        return true;
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
        $this->getInheritanceResolver()->getFilter()->setValidationGroup(
            ['avatar']
        );

        try {
            $result = $this->update($identity, $data);
        } catch (\S0mWeb\WTL\Crud\Exception\ValidationException $e) {
            return ['errors' => $e->getValidationMessages()];
        }

        $this->getInheritanceResolver()->getFilter()->setValidationGroup(InputFilterInterface::VALIDATE_ALL);

        return $result;
    }
}
