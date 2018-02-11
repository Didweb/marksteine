<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\BaseTesting;
use Symfony\Component\HttpFoundation\Response;

class AdminMilestoneControllerTest extends BaseTesting
{


    public function testIndex()
    {

        $crawler = $this->client->request('GET', '/admin/milestone/list/1');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
    * Access test  allowed (ROLE_USER).
    */
    public function testIndexAdminMilestoneAccessUser()
    {
        $this->logIn('ROLE_USER');
        $crawler = $this->client->request('GET', '/admin/milestone/list/1');

        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    /**
    * Access test  allowed (ROLE_COLLABORATOR).
    */
    public function testIndexAdminMilestoneAccessCollaborator()
    {
        $this->logIn('ROLE_COLLABORATOR');
        $crawler = $this->client->request('GET', '/admin/milestone/list/1');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    /**
    * Access test  allowed (ROLE_MANAGER).
    */
    public function testIndexAdminAccessMilestoneManager()
    {
        $this->logIn('ROLE_MANAGER');
        $crawler = $this->client->request('GET', '/admin/milestone/list/1');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }



    /**
    * Access test  allowed (ROLE_ADMIN).
    */
    public function testIndexAdminAccessAdminMilestone()
    {
        $this->logIn('ROLE_ADMIN');
        $crawler = $this->client->request('GET', '/admin/milestone/list/1');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    /**
    * Access test  allowed (ROLE_SUPER_ADMIN).
    */
    public function testIndexAdminMilestoneAccessSuperAdmin()
    {
        $this->logIn('ROLE_SUPER_ADMIN');
        $crawler = $this->client->request('GET', '/admin/milestone/list/1');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}
