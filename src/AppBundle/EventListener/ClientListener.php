<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Client;
use AppBundle\Entity\Company;
use AppBundle\Manager\MailManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ClientListener implements EventSubscriber
{
    /** @var MailManager $mailService */
    private $mailService;
    /** @var TokenStorageInterface $tokenStorage */
    private $tokenStorage;
    private $fromName;
    private $fromEmail;

    public function __construct(MailManager $mailService, TokenStorageInterface $tokenStorage, $fromName, $fromEmail)
    {
        $this->mailService = $mailService;
        $this->tokenStorage = $tokenStorage;
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
    }


    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Client) {

            $mail_params = array(
                'name' => $entity->getName(),
                'email' => $entity->getEmail(),
                'message' => 'New Client created.',
                'phone' => $entity->getPhone()
            );

            /** @var Company $company */
            $company = $entity->getCompany();
            $to = [$company->getContactEmail()];

            if ($token = $this->tokenStorage->getToken()) {
                $user = $token->getUser();
                $to = $to + $user->getEmail();
            }

            $from = $this->fromEmail;
            $fromName = $this->fromName;

            $this->mailService->sendEmail('created', $mail_params, $to, $from, $fromName);
        }
    }
}
