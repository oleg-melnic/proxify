<?php
namespace App\Service\User\Social;

use App\Entity\User\Social\Social as EntitySocial;
use S0mWeb\WTL\Crud\CrudInterface;
use S0mWeb\WTL\Crud\Helper\DeleteTrait;
use S0mWeb\WTL\Crud\Helper\ReadTrait;
use S0mWeb\WTL\Crud\NoInheritanceAwareInterface;
use S0mWeb\WTL\Crud\NoInheritanceAwareTrait;
use S0mWeb\WTL\StdLib\EntityManagerAwareInterface;
use S0mWeb\WTL\StdLib\EntityManagerAwareTrait;

/**
 * Service for social providers
 */
class Social implements CrudInterface, NoInheritanceAwareInterface, EntityManagerAwareInterface
{
    use ReadTrait;
    use DeleteTrait;
    use NoInheritanceAwareTrait;
    use EntityManagerAwareTrait;

    /**
     * @param array $data
     *
     * @return EntitySocial
     */
    public function createEmptyEntity(array $data)
    {
        return new EntitySocial();
    }

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\User\Social\Social::class;
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
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getRepository()
    {
        return $this->getInheritanceResolver()->getRepository();
    }

    /**
     * @param $alias
     *
     * @return \App\Entity\User\Social\Social
     */
    public function findByAlias($alias)
    {
        return $this->getRepository()->findOneBy(['alias' => $alias]);
    }

    /**
     * @return EntitySocial[]|null
     */
    public function getAllSocialServices()
    {
        return $this->getRepository()->findAll();
    }
}
