<?php

namespace AppBundle\Repository;

/**
 * Class CompanyRepository
 */
class CompanyRepository extends BaseRepository
{
    /**
     * 3.1. Search for Companies by employees range.
     * Employees range: i.e. list Companies that has employees range between 500 and 2000
     *
     * @return null|array
     */
    public function findByEmployeesRange()
    {
        return $this->createQueryBuilder('c')
                    ->where('c.employees >= 500 AND c.employees <= 2000')
                    ->getQuery()
                    ->getResult();
    }
}
