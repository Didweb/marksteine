<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\BaseTesting;
use Symfony\Component\HttpFoundation\Response;

class EraControllerTest extends BaseTesting
{

    public function testIndex()
    {
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request('GET', '/admin/era/list/1');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testIndexError()
    {
        $crawler = $this->client->request('GET', '/admin/era/list/1');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

}
