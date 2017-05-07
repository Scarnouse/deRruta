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
            ->where('p.route = :route')->setParameter('route', $route)
            ->orderBy('p.date', 'ASC');

        $query = $sql->getQuery();

        return $query->getResult();
    }

    //find by id
    public function findById($id)
    {
        $sql = $this->createQueryBuilder('p')
            ->where('p.id = :id')->setParameter('id', $id);

        $query = $sql->getQuery();

        return $query->getResult();
    }

    public function findByRouteAndLatitudeAndLongitude($route, $latitude, $longitude)
    {
        if ($this->findByRoute($route))
        {
            $sql = $this->createQueryBuilder('p')
                ->where('p.latitude = :latitude')->setParameter('latitude', $latitude)
                ->andWhere('p.longitude = :longitude')->setParameter('longitude', $longitude);

            $query = $sql->getQuery();

            return $query->getOneOrNullResult();
        }

        return null;
    }

}