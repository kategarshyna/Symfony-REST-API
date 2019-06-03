<?php


namespace AppBundle\Controller;

use AppBundle\Tests\Phpunit\BaseApiTestCase;

/**
 * Class CompanyControllerTest
 * @package AppBundle\Controller
 */
class ClientControllerTest extends BaseApiTestCase
{

    public function testClientPost()
    {
        $accessToken        = $this->getOAuthToken('admin1', 'admin1');
        $method             = 'POST';
        $uri                = '/api/v1/client';
        $parameters = [
            'name' => 'testName',
            'email' => "test+" . rand(0, 1000) . "@test.com",
            'phone' => '65688888',
            'company_id' => ''
        ];
        $response           = $this->request($method, $uri, $accessToken, $parameters);

        $this->assertTrue($response->isSuccessful());
    }

    public function testClientPatch()
    {
        $accessToken        = $this->getOAuthToken('admin1', 'admin1');
        $method             = 'PATCH';
        $uri                = '/api/v1/client?id=14';
        $parameters         = ['name' => 'testName14'];
        $response           = $this->request($method, $uri, $accessToken, $parameters);

        $this->assertTrue($response->isSuccessful());
    }
}
