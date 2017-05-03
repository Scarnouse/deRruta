<?php

namespace DrutaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository
{
    //find one by name
    public function findByName($name)
    {
        $sql = $this->createQueryBuilder('r');
        $sql->where('r.name = :name')->setParameter('name', $name);

        $query = $sql->getQuery();

        return $query->getResult();
    }
}