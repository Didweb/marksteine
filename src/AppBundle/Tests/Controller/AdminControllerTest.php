<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Tests\BaseTesting;
use Symfony\Component\HttpFoundation\Response;

class AdminControllerTest extends BaseTesting
{

    /**
    * Access test not allowed (visitor user).
    */
    public function testIndexAdminNotPermission()
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }


    /**
    * Access test  allowed (ROLE_USER).
    */
    public function testIndexAdminAccessUser()
    {
        $this->logIn('ROLE_USER');
        $crawler = $this->client->request('GET', '/admin/');

        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    /**
    * Access test  allowed (ROLE_COLLABORATOR).
    */
    public function testIndexAdminAccessCollaborator()
    {
        $this->logIn('ROLE_COLLABORATOR');
        $crawler = $this->client->request('GET', '/admin/');

        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    /**
    * Access test  allowed (ROLE_MANAGER).
    */
    public function testIndexAdminAccessManager()
    {
        $this->logIn('ROLE_MANAGER');
        $crawler = $this->client->request('GET', '/admin/');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }



    /**
    * Access test  allowed (ROLE_ADMIN).
    */
    public function testIndexAdminAccessAdmin()
    {
        $this->logIn('ROLE_ADMIN');
        $crawler = $this->client->request('GET', '/admin/');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    /**
    * Access test  allowed (ROLE_SUPER_ADMIN).
    */
    public function testIndexAdminAccessSuperAdmin()
    {
        $this->logIn('ROLE_SUPER_ADMIN');
        $crawler = $this->client->request('GET', '/admin/');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}
