<?php

namespace App\Crud\Helper;

trait UpdateTrait
{
    /**
     * @param int $identity
     * @param array $data
     * @param array $context
     * @param string $permission
     *
     * @return object
     *
     */
    public function update($identity, array $data, array $context = [], $permission = __FUNCTION__)
    {
        $entity = $this->find($identity);

        $fullData = $this->getFullData($entity, $data);
        $entity   = $this->buildEntity($fullData, $entity, $context);
        $this->save();

        return $entity;
    }

    /**
     * Получить смереженные данные сущности и $data
     *
     * @param object $entity
     * @param array  $data
     *
     * @return array
     */
    public function getFullData($entity, array $data)
    {
        return $this->getStrategy()->extract($data, $entity, $this->getHydrator());
    }
}
