<?php
namespace App\Service\Event;

use App\Crud\CrudInterface;
use App\Crud\CrudTrait;
use App\Entity\Event\Offline as OfflineEventEntity;
use App\Service\ServiceAbstract;

class Offline extends ServiceAbstract implements CrudInterface
{
    use CrudTrait;

    /**
     * @param array $data
     *
     * @return OfflineEventEntity
     */
    public function createEmptyEntity(array $data)
    {
        return new OfflineEventEntity();
    }

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\Event\Offline::class;
    }

    /**
     * @param $alias
     * @return OfflineEventEntity|null
     *
     */
    public function findByAlias($alias)
    {
        return $this->repository->findOneByAlias($alias);
    }

    /**
     * Get list of upcoming offline events for current user
     *
     * @param integer $userId
     * @return \App\Entity\Event\Offline[]
     */
    public function getUpcomingOfflineEvents($userId)
    {
        return $this->repository->getUpcomingOfflineEvents($userId);
    }

    /**
     * Get list of past offline events for current user
     *
     * @param integer $userId
     * @return \App\Entity\Event\Offline[]
     */
    public function getPastOfflineEvents($userId)
    {
        return $this->repository->getPastOfflineEvents($userId);
    }
}
