<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Entity\Company;
use AppBundle\Form\Type\ClientType;
use AppBundle\Manager\ClientManager;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class ClientController
 */
class ClientController extends FOSRestController
{
    /**
     * Get Client detail
     *
     * ### Response ###
     *  <code>
     *       "client": {
     *         "id": ##,
     *         "email": string,
     *         "name": string,
     *         "phone": string,
     *         "users": array,
     *         "company": array
     *       }
     * </code>
     *
     * @ApiDoc(
     *     section = "Client",
     *     description="Get client info.",
     *     statusCodes={200 = "OK", 400 = "Bad request"},
     *     resource=true
     * )
     *
     * @param ParamFetcher $paramFetcher
     *
     * @FOS\QueryParam(name="id", requirements="\d+", strict=true, nullable=false, allowBlank=false)
     *
     * @FOS\Route("/client", methods={"GET"})
     *
     * @return Client
     */
    public function getClientAction(ParamFetcher $paramFetcher)
    {
        return $this->getDoctrine()->getRepository('AppBundle:Client')->findOneBy([
            'id' => $paramFetcher->get('id')
        ]);
    }

    /**
     * Create new Client
     *
     * ### Response ###
     *  <code>
     *       "client": {
     *         "id": ##,
     *         "email": string,
     *         "name": string,
     *         "phone": string,
     *         "users": array,
     *         "company": array
     *       }
     * </code>
     *
     * @ApiDoc(
     *     section = "Client",
     *     description="Create new client.",
     *     statusCodes={200 = "OK", 400 = "Bad request"},
     *     resource=true
     * )
     *
     * @param Request $request
     *
     * @FOS\RequestParam(name="name", requirements="[a-zA-Z]+", strict=true, nullable=false, allowBlank=false)
     * @FOS\RequestParam(name="email", requirements=".+", strict=true, nullable=false, allowBlank=false)
     * @FOS\RequestParam(name="phone", requirements="\d+", strict=true, nullable=false, allowBlank=false)
     * @FOS\RequestParam(name="company_id", requirements="\d+", strict=true, nullable=false, allowBlank=false)
     *
     * @FOS\Route("/client", methods={"POST"})
     *
     * @return View
     */
    public function postClientAction(Request $request)
    {
        /** @var ClientManager $clientManager */
        $clientManager = $this->get('active_app.client_manager');
        $client = $clientManager->createClient();

        if ($company_id = $request->request->get('company_id')) {
            /** @var Company $company */
            if(!$company = $this->getDoctrine()->getRepository('AppBundle:Company')->findOneBy([
                'id' => $company_id
            ])) {
                throw new NotFoundResourceException;
            }
            $client->setCompany($company);
        }

        $form = $this->createForm(new ClientType(), $client);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $clientManager->save($client);

            return $this->view($client, Response::HTTP_OK);
        }

        return $this->view($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }


    /**
     * Update Client
     *
     * ### Response ###
     *  <code>
     *       "client": {
     *         "id": ##,
     *         "email": string,
     *         "name": string,
     *         "phone": string,
     *         "users": array,
     *         "company": array
     *       }
     * </code>
     *
     * @ApiDoc(
     *     section = "Client",
     *     description="Update client.",
     *     statusCodes={200 = "OK", 400 = "Bad request"},
     *     resource=true
     * )
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     *
     * @FOS\QueryParam(name="id", requirements="\d+", strict=true, nullable=false, allowBlank=false)
     *
     * @FOS\RequestParam(name="name", requirements="[a-zA-Z]+", strict=true, nullable=true, allowBlank=true)
     * @FOS\RequestParam(name="email", requirements=".+", strict=true, nullable=true, allowBlank=true)
     * @FOS\RequestParam(name="phone", requirements="\d+", strict=true, nullable=true, allowBlank=true)
     * @FOS\RequestParam(name="company_id", requirements="\d+", strict=true, nullable=true, allowBlank=true)
     *
     * @FOS\Route("/client", methods={"PATCH"})
     *
     * @return View
     */
    public function patchClientAction(Request $request, ParamFetcher $paramFetcher)
    {
        /** @var ClientManager $clientManager */
        $clientManager = $this->get('active_app.client_manager');
        /** @var Client $client */
        $client = $clientManager->getFind($paramFetcher->get('id'));

        if (!$client) {
            throw new ResourceNotFoundException;
        }

        if ($company_id = $request->request->get('company_id')) {
            /** @var Company $company */
            if (!$company = $this->getDoctrine()->getRepository('AppBundle:Company')->findOneBy([
                'id' => $company_id
            ])) {
                throw new ResourceNotFoundException;
            }

            $client->setCompany($company);
        }

        $form = $this->createForm(new ClientType(), $client);
        $form->submit($request->request->all(), false);
        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            return $this->view($client, Response::HTTP_OK);
        }

        return $this->view($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }
}
