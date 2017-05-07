<?php

namespace DrutaBundle\Model;

use Doctrine\ORM\EntityManagerInterface;
use DrutaBundle\Entity\Route;

class RouteModel
{
    /**
     * @var \DrutaBundle\Entity\RouteRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository('DrutaBundle:Route');
        $this->entityManager = $entityManager;
    }

    public function add(Route $route)
    {
        $this->entityManager->persist($route);
    }

    public function update(Route $route)
    {
        $this->entityManager->persist($route);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    public function findByUser($user)
    {
        return $this->repository->findByUser($user);
    }

    public function removeRoute($route)
    {
        $this->entityManager->remove($route);
    }

    public function applyChanges(){
        $this->entityManager->flush();
    }

}
