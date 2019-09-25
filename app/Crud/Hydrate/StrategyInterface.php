<?php

namespace App\Crud\Hydrate;

use Zend\Hydrator\HydratorInterface;

/**
 * Interface StrategyInterface
 */
interface StrategyInterface
{
    /**
     * @param array $data
     * @param object $entity
     * @param HydratorInterface $hydrator
     *
     * @return array
     */
    public function extract(array $data, $entity, HydratorInterface $hydrator);

    /**
     * @param object $entity
     * @param array $data
     * @param HydratorInterface $hydrator
     *
     * @return object $entity
     */
    public function hydrate($entity, array $data, HydratorInterface $hydrator);
}
