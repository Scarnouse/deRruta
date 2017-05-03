<?php

namespace DrutaBundle\Util;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query;

class DoctrineHelp
{
    static public function paginate(Query $query, &$pageSize = 15, &$currentPage = 1)
    {
        $pageSize = (int)$pageSize;
        $currentPage = (int)$currentPage;

        if($pageSize < 1)
        {
            $pageSize = 10;
        }

        if($currentPage < 1)
        {
            $currentPage = 1;
        }

        $paginator = new Paginator($query);

        $paginator->getQuery()
            ->setFirstResult($pageSize * ($currentPage -1 ))
            ->setMaxResults($pageSize);

        return $paginator;
    }
}