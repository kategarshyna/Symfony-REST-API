<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Manager\UserManager;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;

/**
 * Class UserController
 */
class UserController extends FOSRestController
{
    /**
     * ---------------------------------------
     * -- MAKE ALL THE CHANGES YOU SEE FIT. --
     * ---------------------------------------
     */

    /**
     * Gets an user profile through it's email.
     *
     * ### Response ###
     *  <code>
     *       "user": {
     *         "id": ##,
     *         "email": string,
     *         "username": string,
     *         "firstname": string,
     *         "lastname": string,
     *       }
     * </code>
     *
     * @ApiDoc(
     *     section = "User",
     *     description="Get user profile info.",
     *     statusCodes={200 = "OK", 400 = "Bad request"},
     *     resource=true
     * )
     *
     * @FOS\QueryParam(name="email", requirements=".+", strict=true, nullable=false, allowBlank=false)
     *
     * @FOS\Route("/users/profile", methods={"GET"})
     *
     * @FOS\View(serializerGroups={"Users"})
     *
     * @return User
     */
    public function getProfileAction(ParamFetcher $paramFetcher)
    {
        return $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(['email' => $paramFetcher->get('email')]);
    }

    /**
     * Update a User
     *
     * ### Response ###
     *  <code>
     *       "user": {
     *         "id": ##,
     *         "email": string,
     *         "username": string,
     *         "firstname": string,
     *         "lastname": string,
     *       }
     * </code>
     *
     * @ApiDoc(
     *     section = "User",
     *     description="Update an user profile info.",
     *     statusCodes={200 = "OK", 400 = "Bad request"},
     *     resource=true
     * )
     *
     * @FOS\Route("/{id}", requirements={"id"="\d+"}, methods={"PATCH"}, name="update_patch")
     *
     * @FOS\View(serializerGroups={"Users"})
     *
     * @return User
     */
    public function patchAction(ParamFetcher $paramFetcher)
    {
        return new User();
    }

    /**
     * Update a User
     *
     * ### Response ###
     *  <code>
     *       "user": {
     *         "id": ##,
     *         "email": string,
     *         "username": string,
     *         "firstname": string,
     *         "lastname": string,
     *       }
     * </code>
     *
     * @ApiDoc(
     *     section = "User",
     *     description="Update an user profile info.",
     *     statusCodes={200 = "OK", 400 = "Bad request"},
     *     resource=true
     * )
     *
     * @FOS\Route("/{id}", requirements={"id"="\d+"}, methods={"PUT"}, name="update_put")
     *
     * @FOS\View(serializerGroups={"Users"})
     *
     * @return User
     */
    public function putAction(ParamFetcher $paramFetcher)
    {
        return new User();
    }
}
