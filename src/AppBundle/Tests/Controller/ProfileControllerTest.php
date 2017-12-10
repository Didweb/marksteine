<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Entity\Profile;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProfileControllerTest extends WebTestCase
{


    private $client = null;
    private $dummyUser;
    private $em;
    private $container;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = static::$kernel->getContainer();
        $this->em = static::$kernel->getContainer()
                              ->get('doctrine')
                              ->getManager();
    }

    /**
    * Access test not allowed (visitor user).
    */
    public function testIndexProfileNotPermission()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/profile');

        $this->assertEquals(301, $client->getResponse()->getStatusCode());
    }

    /**
    * Access test not allowed (visitor user).
    */
    public function testEditProfileNotPermission()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/profile/edit');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
    * Access test  allowed (ROLE_USER).
    */
    public function testIndexProfileAccessUser()
    {
        $this->logIn('ROLE_USER');
        $crawler = $this->client->request('GET', '/profile/');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    /**
    * Access test  allowed (ROLE_COLLABORATOR).
    */
    public function testIndexProfileAccessCollaborator()
    {
        $this->logIn('ROLE_COLLABORATOR');
        $crawler = $this->client->request('GET', '/profile/');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    /**
    * Access test  allowed (ROLE_COLLABORATOR).
    */
    public function testIndexProfileAccessManager()
    {
        $this->logIn('ROLE_MANAGER');
        $crawler = $this->client->request('GET', '/profile/');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }


    /**
    * Access test  allowed (ROLE_ADMIN).
    */
    public function testIndexProfileAccessAdmin()
    {
        $this->logIn('ROLE_ADMIN');
        $crawler = $this->client->request('GET', '/profile/');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    /**
    * Access test  allowed (ROLE_SUPER_ADMIN).
    */
    public function testIndexProfileAccessSuperAdmin()
    {
        $this->logIn('ROLE_SUPER_ADMIN');
        $crawler = $this->client->request('GET', '/profile/');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testEditProfile()
    {
        $user = $this->em->getRepository('AppBundle:User')->findOneByUsername('Dummy');
        if (!$user) {
             $user = new User();
             $user->setUsername('Dummy');
             $user->setPlainPassword('Dummy');
             $user->setEmail('Dummy@Dummy.com');
             $user->setEnabled(true);
             $user->setFirstName('Dummy');
             $this->em->persist($user);
             $this->em->flush();
        }

        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('security.login.submit')->form();
        $crawler = $this->client->submit($form, array('_username' => 'Dummy', '_password' => 'Dummy'));

        $photo = new UploadedFile(
            'web/avatars/test.jpeg',
            'test.jpg',
            'image/jpeg',
            123
        );

        $crawler = $this->client->request(
            'POST',
            '/profile/edit',
            array(),
            array(),
            array(),
            json_encode(
                array('appbundle_user[firstName]' => 'TestMe',
                              'appbundle_user[file]' => $photo,
                              'isValid' => true,
                              'isSubmitted'=> true)
            )
        );
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }


    /**
    * Login
    */
    private function logIn($role, $user = 'admin')
    {
        $session = $this->client->getContainer()->get('session');
        $firewallContext = 'main';

        $token = new UsernamePasswordToken($user, null, $firewallContext, array($role));

        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }


    protected function tearDown()
    {
        $this->em->close();
        unset($this->client);
    }
}
