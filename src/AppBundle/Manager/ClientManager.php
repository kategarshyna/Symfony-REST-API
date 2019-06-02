<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Client;
use AppBundle\Repository\ClientRepository;
use JMS\DiExtraBundle\Annotation\Service;

/**
 * @Service("entity_manager")
 */
class ClientManager extends BaseManager
{
    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Client
     */
    public function createClient()
    {
        return new Client();
    }
}
