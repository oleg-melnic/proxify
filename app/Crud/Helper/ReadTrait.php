<?php

namespace App\Crud\Helper;

use App\Crud\Exception\EntityNotFound;

trait ReadTrait
{
    /**
     * @param int $identity
     *
     * @return object
     *
     * @throws EntityNotFound
     */
    public function find($identity)
    {
        if (is_null($entity = $this->repository->find($identity))) {
            throw new EntityNotFound(
                sprintf('Сущности %s с таким id не существует %s', $this->getBaseEntityName(), $identity)
            );
        } else {
            return $entity;
        }
    }

    /**
     * @param int $identity
     *
     * @return bool
     */
    public function has($identity)
    {
        if (is_null($this->repository->find($identity))) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Получение в виде массива данных об объекте
     *
     * @param $identity
     *
     * @return array
     */
    public function extract($identity)
    {
        $entity = $this->find($identity);
        return $this->getStrategy()->extract([], $entity, $this->getHydrator());
    }
}
