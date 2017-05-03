<?php

namespace DrutaBundle\Model;

use Doctrine\ORM\EntityManagerInterface;
use DrutaBundle\Entity\POI;

class POIModel
{
    /**
     * @var \DrutaBundle\Entity\POIRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository('DrutaBundle:POI');
        $this->entityManager = $entityManager;
    }

    public function add(POI $poi)
    {
        $this->entityManager->persist($poi);
    }

    public function update(POI $poi)
    {
        $this->entityManager->persist($poi);
    }

    public function findByRoute($route)
    {
        return $this->repository->findByRoute($route);
    }

    public function applyChanges(){
        $this->entityManager->flush();
    }

}

