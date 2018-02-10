<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AdminMilestoneControllerTest extends WebTestCase
{

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

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

        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
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

    private function logIn($role)
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewallContext, array($role));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
