<?php
namespace App\Service\User\Social;

use App\Entity\Social\SocialCustomAuthUserWrapper;
use App\Entity\User\Social\Social as SocialEntity;
use App\Entity\User\Social\User as SocialUser;
use App\Entity\User\State;
use App\Entity\User\UserAbstract;
use App\Service\Mail\User\Social\MailService;
use App\Service\User\User as S0mUser;
use Behat\Transliterator\Transliterator;
use S0mWeb\WTL\Crud\CrudInterface;
use S0mWeb\WTL\Crud\CrudTrait;
use S0mWeb\WTL\Crud\Exception\DeletionFailed;
use S0mWeb\WTL\Crud\NoInheritanceAwareInterface;
use S0mWeb\WTL\Crud\NoInheritanceAwareTrait;

/**
 * Service for social user
 */
class User implements CrudInterface, NoInheritanceAwareInterface
{
    use CrudTrait;
    use NoInheritanceAwareTrait;

    /** @var S0mUser */
    protected $clientService;

    /** @var MailService */
    protected $mailService;

    /** @var Social */
    protected $socialService;

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\User\Social\User::class;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getRepository()
    {
        return $this->getInheritanceResolver()->getRepository();
    }

    /**
     * @param $key
     * @param $socialId
     *
     * @return SocialUser
     */
    public function findBySocialKey($key, $socialId)
    {
        return $this->getRepository()->findOneBy(['key' => $key, 'social' => $socialId]);
    }

    /**
     * @param $key
     * @param $socialId
     *
     * @return UserAbstract|null
     */
    public function findMainUserBySocialKeyActive($key, $socialId)
    {
        $socialUser = $this->getRepository()->findMainUserBySocialKeyActive(
            $key,
            $socialId
        );
        $user = $socialUser ? $socialUser->getUser() : null;
        return $user;
    }

    /**
     * Получить социальных клиентов о клиенту гуру
     *
     * @param $client
     * @return array
     */
    public function findAllByClient($client)
    {
        return $this->getRepository()->findBy(['user' => $client]);
    }

    /**
     * @param $user
     * @param $social
     *
     * @return SocialUser | null
     */
    public function findByUserAndSocial($user, $social)
    {
        return $this->getRepository()->findOneBy(['user' => $user, 'social' => $social]);
    }

    /**
     * @param UserAbstract $user
     * @param SocialEntity $social
     * @param string $socialIdentity
     *
     * @return SocialUser
     */
    public function register($user, $social, $socialIdentity)
    {
        $entity = $this->findByUserAndSocial($user, $social);
        $data = [
            'user' => $user,
            'social' => $social,
            'key' => $socialIdentity,
            'state' => \App\Entity\User\Social\State::createFromScalar(
                \App\Entity\User\Social\State::AUTHENTICATED
            )
        ];
        if ($entity === null) {
            $entity = $this->create($data);
        } elseif ($entity && !$entity->getState()->getValue()) {
            $data = [
                'state' => \App\Entity\User\Social\State::createFromScalar(
                    \App\Entity\User\Social\State::AUTHENTICATED
                )
            ];

            $entity = $this->update($entity->getIdentity(), $data);
        }

        return $entity;
    }

    /**
     * Создание сущности
     *
     * @param array  $data
     * @param bool   $flush
     * @param array  $context    - контекст для валидаторов
     * @param string $permission - от какого acl permission выполняется действие
     *
     *
     * @return object
     */
    public function create(array $data, $flush = true, array $context = [], $permission = __FUNCTION__)
    {
        $context['identity'] = '';

        return $this->getInheritanceResolver()->create($data, $flush, $context, $permission);
    }

    /**
     * Обновление сущности
     *
     * @param int|array $identity ключ может быть составным
     * @param array     $data
     * @param array     $context
     * @param string    $permission
     *
     * @return object
     */
    public function update($identity, array $data, array $context = [], $permission = __FUNCTION__)
    {
        $context['identity'] = $identity;

        return $this->getInheritanceResolver()->update($identity, $data, $context, $permission);
    }

    /**
     * @param int $identity
     * @throws DeletionFailed
     * @return bool
     */
    public function delete($identity)
    {
        return $this->getInheritanceResolver()->delete($identity);
    }

    /**
     * @param SocialCustomAuthUserWrapper $socialAuthUserWrapper
     * @return UserAbstract
     */
    public function createUser(SocialCustomAuthUserWrapper $socialAuthUserWrapper)
    {
        $email = $socialAuthUserWrapper->getMail();
        if (!$email) {
            throw new \App\Service\Exception\ValidationException(
                "Social network did not return email."
            );
        }

        $userEntity = $this->checkUserExistance($email);

        if (!$userEntity) {
            $data = [];
            $data['email'] = $email;
            $data['fullName'] = ucwords(
                Transliterator::transliterate($socialAuthUserWrapper->getDisplayName(), ' ')
            );
            $data['type'] = \App\Service\User\User::TYPE_STUDENT;
            $data['password'] = Rand::getString(10, 'abcdefghijklmnopqrstuvwxyz123456789');
            $data['birthday'] = $socialAuthUserWrapper->getBirthday();
            $data['state'] = State::createFromScalar(State::ACTIVE);

            try {
                $userEntity = $this->getClientService()->create($data);
            } catch (\Exception $exception) {
                throw new \App\Service\Exception\ValidationException(
                    "Cannot create user from social network data."
                );
            }
            $this->getMailService()->registrationEmail($data);
        }

        return $userEntity;
    }

    public function checkUserExistance($email)
    {
        $userEntity = $this->getClientService()->getEntityByEmail($email);

        if ($userEntity) {
            return $userEntity;
        }

        return false;
    }

    public function checkSocialUserExistanceById($key)
    {
        return $this->getRepository()->findOneBy(['key' => $key, 'social' => $socialId]);
    }

    /**
     * @return S0mUser
     */
    public function getClientService()
    {
        return $this->clientService;
    }

    /**
     * @param S0mUser $clientService
     */
    public function setClientService($clientService)
    {
        $this->clientService = $clientService;
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
     * @param array $data
     *
     * @return SocialUser
     */
    public function createEmptyEntity(array $data)
    {
        return new SocialUser($data['user'], $data['social'], $data['key'], $data['state']);
    }

    /**
     * @return Social
     */
    public function getSocialService()
    {
        return $this->socialService;
    }

    /**
     * @param Social $socialService
     */
    public function setSocialService($socialService)
    {
        $this->socialService = $socialService;
    }

    /**
     * @param UserAbstract $user
     * @param SocialEntity $social
     * @param string $socialIdentity
     *
     * @return SocialUser
     */
    public function disconnect($user, $social)
    {
        $this->getInheritanceResolver()->getFilter()->setValidationGroup(
            ['state']
        );

        $entity = $this->findByUserAndSocial($user, $social);
        $data = [
            'state' => \App\Entity\User\Social\State::createFromScalar(
                \App\Entity\User\Social\State::UNAUTHENTICATED
            )
        ];

        try {
            $this->getInheritanceResolver()->validate($data, null, []);
            $this->update($entity->getIdentity(), $data);
        } catch (\S0mWeb\WTL\Crud\Exception\ValidationException $e) {
            return ['errors' => $e->getValidationMessages()];
        }

        $this->getInheritanceResolver()->getFilter()->setValidationGroup(InputFilterInterface::VALIDATE_ALL);

        return $entity;
    }
}
