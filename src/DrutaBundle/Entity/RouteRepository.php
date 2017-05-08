<?php

namespace DrutaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class RouteRepository extends EntityRepository
{
    //find by user
    public function findByUser($user)
    {
        $sql = $this->createQueryBuilder('r');
        $sql->where('r.user = :user')->setParameter('user', $user)
            ->orderBy('r.date', 'DESC');

        $query = $sql->getQuery();

        return $query->getResult();
    }

    //find all
    public function findAll()
    {
        $sql = $this->createQueryBuilder('r')
            ->orderBy('r.date', 'DESC');

        $query = $sql->getQuery();

        return $query->getResult();
    }

    //find by id
    public function findById($id)
    {
        $sql = $this->createQueryBuilder('r')
            ->where('r.id = :id')->setParameter('id', $id);

        $query = $sql->getQuery();

        return $query->getOneOrNullResult();
    }

}