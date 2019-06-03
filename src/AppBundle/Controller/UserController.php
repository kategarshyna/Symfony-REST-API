<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use AppBundle\Manager\UserManager;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class UserController
 */
class UserController extends FOSRestController
{
    /**
     * Get all users. Filter by username.
     *
     * ### Response ###
     *  <code>
     *       "user": {
     *         "id": ##,
     *         "email": string,
     *         "username": string,
     *         "roles": array
     *         "groups": array
     *         "first_name": string,
     *         "last_name": string,
     *         "clients": array
     *       }
     * </code>
     *
     * @ApiDoc(
     *     section = "User",
     *     description="Get all users. Filter by username.",
     *     statusCodes={200 = "OK", 400 = "Bad request"},
     *     resource=true
     * )
     *
     * @param ParamFetcher $paramFetcher
     *
     * @FOS\QueryParam(name="username", requirements="[a-zA-Z]+", strict=true, nullable=true, allowBlank=true)
     *
     * @FOS\Route("/users/all", methods={"GET"})
     *
     * @return array
     */
    public function getUsersAllAction(ParamFetcher $paramFetcher)
    {
        if (!empty($paramFetcher->get('username'))) {
            return $this->getDoctrine()->getRepository('AppBundle:User')->findBy([
                "username" => $paramFetcher->get('username')
            ]);
        }

        return $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
    }

    public function sendUserUpdatedEmail($data)
    {
        $mail_params = array(
            'firstName' => $data["firstName"],
            'lastName' => $data["lastName"],
            'message' => $data["message"],
            'email' => $data["email"]
        );

        $to = $data["email"];
        $from = $this->container->getParameter('from_email');
        $fromName = $this->container->getParameter('from_name');

        $message = $this->container->get('mail_manager');

        return $message->sendEmail('updated', $mail_params, $to, $from, $fromName);
    }

    /**
     * Gets an user by id.
     *
     * ### Response ###
     *  <code>
     *       "user": {
     *         "id": ##,
     *         "email": string,
     *         "username": string,
     *         "roles": array
     *         "groups": array
     *         "first_name": string,
     *         "last_name": string,
     *         "clients": array
     *       }
     * </code>
     *
     * @ApiDoc(
     *     section = "User",
     *     description="Get user by id.",
     *     statusCodes={200 = "OK", 400 = "Bad request"},
     *     resource=true
     * )
     *
     * @param ParamFetcher $paramFetcher
     *
     * @FOS\QueryParam(name="id", requirements="\d+", strict=true, nullable=false, allowBlank=false)
     *
     * @FOS\Route("/users", methods={"GET"})
     *
     * @return User
     */
    public function getUserAction(ParamFetcher $paramFetcher)
    {
        return $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy([
            'id' => $paramFetcher->get('id')
        ]);
    }

    /**
     * Gets an user profile through it's email.
     *
     * ### Response ###
     *  <code>
     *       "user": {
     *         "id": ##,
     *         "email": string,
     *         "username": string,
     *         "roles": array
     *         "groups": array
     *         "first_name": string,
     *         "last_name": string,
     *         "clients": array
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
     * @FOS\QueryParam(name="email", requirements="^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+", strict=true, nullable=false, allowBlank=false)
     *
     * @FOS\Route("/users/profile", methods={"GET"})
     *
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
     *         "roles": array
     *         "groups": array
     *         "first_name": string,
     *         "last_name": string,
     *         "clients": array
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
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     *
     * @FOS\QueryParam(name="id", requirements="\d+", strict=true, nullable=false, allowBlank=false)
     *
     * @FOS\RequestParam(name="username", requirements="[a-zA-Z]+", strict=true, nullable=false, allowBlank=false)
     * @FOS\RequestParam(name="email", requirements=".+", strict=true, nullable=false, allowBlank=false)
     * @FOS\RequestParam(name="first_name", requirements=".+", strict=true, nullable=true, allowBlank=true)
     * @FOS\RequestParam(name="last_name", requirements=".+", strict=true, nullable=true, allowBlank=true)
     *
     * @FOS\Route("/users", methods={"PATCH"})
     *
     * @return View
     */
    public function patchUserAction(Request $request, ParamFetcher $paramFetcher)
    {
        /** @var UserManager $userManager */
        $userManager = $this->get('active_app.user_manager');
        /** @var User $user */
        $user = $userManager->getFind($paramFetcher->get('id'));

        if (!$user) {
            throw new ResourceNotFoundException;
        }

        $form = $this->createForm(new UserType(), $user);
        $form->submit($request->request->all(), false);
        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->sendUserUpdatedEmail([
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'message' => 'User data updated',
                'email' => $user->getEmail()
            ]);

            return $this->view($user, Response::HTTP_OK);
        }

        return $this->view($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }
}
