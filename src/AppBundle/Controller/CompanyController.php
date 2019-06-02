<?php

namespace AppBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class CompanyController
 */
class CompanyController extends FOSRestController
{
    /**
     * Get all Companies
     *
     * ### Response ###
     *  <code>
     *       "client": {
     *          "id": ##,
     *          "name": string,
     *          "industry": string,
     *          "revenue_billion": integer,
     *          "market_capital_billion": integer,
     *          "employees": integer,
     *          "headquarters": string,
     *          "contact_email": string,
     *          "client": array
     *       }
     * </code>
     *
     * @ApiDoc(
     *     section = "Company",
     *     description="Get all companies.",
     *     statusCodes={200 = "OK", 400 = "Bad request"},
     *     resource=true
     * )
     *
     * @FOS\Route("/companies/all", methods={"GET"})
     *
     * @return array
     */
    public function getCompaniesAllAction()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Company')->findAll();
    }
}
