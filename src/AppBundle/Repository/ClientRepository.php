<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;

/**
 * Class ClientRepository
 */
class ClientRepository extends BaseRepository
{
    /**
     * 3.2. Search for Clients by: Name: i.e. search within the company's name text
     *
     * @param $name
     * @return null|object
     */
    public function findByName($name)
    {
        return $this->findOneBy([
            'name' => $name
        ]);
    }

    /**
     * 3.2. Search for Clients by: User: i.e. retrieve all Clients a User belongs to
     *
     * @param User $user
     * @return null|object
     */
    public function findByUser($user)
    {
        return $this->createQueryBuilder('clients')
                    ->where('user_client.id = :user_id')
                    ->setParameter('user_id', $user->getId())
                    ->leftJoin('clients.users', 'user_client')
                    ->getQuery()
                    ->execute();
    }
}
