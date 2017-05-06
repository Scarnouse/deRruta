<?php

namespace DrutaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class POIRepository extends EntityRepository
{
    //find by route
    public function findByRoute($route)
    {
        $sql = $this->createQueryBuilder('p')
            ->where('p.route = :route')->setParameter('route', $route);

        $query = $sql->getQuery();

        return $query->getArrayResult();
    }

    //find by id
    public function findById($id)
    {
        $sql = $this->createQueryBuilder('p')
            ->where('p.id = :id')->setParameter('id', $id);

        $query = $sql->getQuery();

        return $query->getResult();
    }

}