<?php

namespace DrutaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    //find one by id
    public function findById($id)
    {
        $sql = $this->createQueryBuilder('u');
        $sql->where('u.id = :id')->setParameter('id', $id)->setMaxResults(1);

        $query = $sql->getQuery();

        return $query->getOneOrNullResult();
    }

    //find one by email
    public function findByEmail($email)
    {
        $sql = $this->createQueryBuilder('u');
        $sql->where('u.email = :email')->setParameter('email', $email);

        $query = $sql->getQuery();

        return $query->getOneOrNullResult();
    }
}