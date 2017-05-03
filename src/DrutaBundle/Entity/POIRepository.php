<?php

namespace DrutaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class POIRepository extends EntityRepository
{
    //find by id
    public function findByRoute($route)
    {
        $sql = $this->createQueryBuilder('p')
            ->where('p.route = :route')->setParameter('route', $route);

        $query = $sql->getQuery();

        ldd($query->getArrayResult());

        return $query->getArrayResult();
    }

}