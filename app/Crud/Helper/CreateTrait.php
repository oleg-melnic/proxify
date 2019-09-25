<?php
namespace App\Crud\Helper;

trait CreateTrait
{
    /**
     * @param array  $data
     * @param bool   $flush
     * @param array  $context
     * @param string $permission
     *
     * @return object
     */
    public function create(array $data, $flush = true, array $context = [], $permission = __FUNCTION__)
    {
        $entity = $this->buildEntity($data, null, $context);
        $this->save($entity, $flush);

        return $entity;
    }

    /**
     * Создать и заполнить Entity из входящих данных
     *
     * @param array  $data
     * @param object $entity
     * @param array  $context
     *
     * @return object
     */
    protected function buildEntity(array $data, $entity = null, array $context = [])
    {
        if (is_null($entity)) {
            $entity = $this->createEmptyEntity();
        }
        $entity = $this->getStrategy()->hydrate($entity, $data, $this->getHydrator());

        return $entity;
    }

    /**
     * @param object $entity
     * @param bool   $flush
     */
    protected function save($entity = null, $flush = true)
    {
        if (!is_null($entity)) {
            $this->em->persist($entity);
        }

        if ($flush) {
            $this->em->flush();
        }
    }
}
