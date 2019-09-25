<?php

namespace App\Service;

use App\Crud\Hydrate\Simple;
use App\Crud\Hydrate\StrategyInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Zend\Hydrator\HydratorAwareInterface;
use Zend\Hydrator\HydratorAwareTrait;

class ServiceAbstract implements HydratorAwareInterface
{
    use HydratorAwareTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var StrategyInterface
     */
    protected $strategy;

    /**
     * @var EntityRepository
     */
    protected $repository;

    public function __construct()
    {
        $this->em = app(EntityManager::class);
        $this->strategy = app(Simple::class);
        $this->repository = $this->em->getRepository($this->getBaseEntityName());
    }

    /**
     * @return StrategyInterface|mixed
     */
    public function getStrategy()
    {
        return $this->strategy;
    }
}
