<?php


namespace AppBundle\Controller;

use AppBundle\Tests\Phpunit\BaseApiTestCase;

/**
 * Class CompanyControllerTest
 * @package AppBundle\Controller
 */
class CompanyControllerTest extends BaseApiTestCase
{

    public function testCompaniesGet()
    {
        $accessToken        = $this->getOAuthToken('admin1', 'admin1');
        $method             = 'GET';
        $uri                = '/api/v1/companies/all';
        $parameters         = [];
        $response           = $this->request($method, $uri, $accessToken, $parameters);

        $this->assertTrue($response->isSuccessful());
    }

}
