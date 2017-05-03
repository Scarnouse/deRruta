<?php

namespace DrutaBundle\Model;

use Doctrine\ORM\EntityManagerInterface;
use DrutaBundle\Entity\Role;

class RoleModel
{
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_USER = "ROLE_USER";

    /**
     * @var \DrutaBundle\Entity\RoleRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository('DrutaBundle:Role');
        $this->entityManager = $entityManager;
    }

    public function add(Role $role)
    {
        $this->entityManager->persist($role);
    }

    public function update(Role $role)
    {
        $this->entityManager->persist($role);
    }

    public function findByName($name)
    {
        return $this->repository->findByName($name);
    }

    public function applyChanges(){
        $this->entityManager->flush();
    }

}