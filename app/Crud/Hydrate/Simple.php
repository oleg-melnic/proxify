<?php

namespace App\Crud\Hydrate;

use Zend\Hydrator\HydratorInterface;

class Simple implements StrategyInterface
{
    /**
     * @param array $data
     * @param object $entity
     * @param HydratorInterface $hydrator
     *
     * @return mixed
     */
    public function extract(array $data, $entity, HydratorInterface $hydrator)
    {
        return array_merge($hydrator->extract($entity), $data);
    }

    /**
     * @param $entity
     * @param array $data
     * @param HydratorInterface $hydrator
     *
     * @return object $entity
     */
    public function hydrate($entity, array $data, HydratorInterface $hydrator)
    {
        return $hydrator->hydrate($data, $entity);
    }
}
