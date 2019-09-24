<?php
namespace App\Service\Auth;

use CirclicalUser\Exception\NoSuchUserException;
use CirclicalUser\Mapper\AuthenticationMapper;
use CirclicalUser\Provider\UserInterface;
use ReflectionClass;

class AuthenticationService extends \CirclicalUser\Service\AuthenticationService
{
    /**
     * @var AuthenticationMapper
     */
    protected $authProvider;

    /**
     * Passed in by a successful form submission, should set proper auth cookies if the identity verifies.
     * The login should work with both username, and email address.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     * @throws NoSuchUserException Thrown when the user can't be identified
     */
    public function authenticateByEntity(UserInterface $user)
    {
        $auth = $this->getAuthProvider()->findByUserId($user->getId());

        if (!$auth) {
            throw new NoSuchUserException();
        }
        $reflection = new ReflectionClass(\CirclicalUser\Service\AuthenticationService::class);

        $this->callPrivateMethod($reflection, $this, 'resetAuthenticationKey', $auth);
        $this->callPrivateMethod($reflection, $this, 'setSessionCookies', $auth);
        $this->callPrivateMethod($reflection, $this, 'setIdentity', $user);

        return $user;
    }

    /**
     * @param ReflectionClass $reflection
     * @param string $methodName
     * @param mixed $param
     */
    protected function callPrivateMethod(ReflectionClass $reflection, $object,  $methodName, $param) {
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        $method->invoke($object, $param);
        $method->setAccessible(false);
    }

    /**
     * @return AuthenticationMapper
     */
    public function getAuthProvider()
    {
        return $this->authProvider;
    }

    /**
     * @param AuthenticationMapper $authProvider
     */
    public function setAuthProvider(AuthenticationMapper $authProvider)
    {
        $this->authProvider = $authProvider;
    }
}
