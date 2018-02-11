<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class Basetesting extends WebTestCase
{
    protected $client = null;
    protected $em;
    protected $container;
    protected $userDummyEntity;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = static::$kernel->getContainer();
        $this->em = static::$kernel->getContainer()
                              ->get('doctrine')
                              ->getManager();
        $this->dummyData();
    }

    protected function dummyData()
    {}

    protected function logIn($role)
    {
        $session = $this->client->getContainer()->get('session');
        $user = $this->userDummy();

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallContext, array($role));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }


    /**
     * Created User Dummy
     */
    protected function userDummy()
    {
        $user = $this->em->getRepository('AppBundle:User')->findOneByUsername('Dummy');
        if (!$user) {
             $user = new User();
             $user->setUsername('Dummy');
             $user->setPlainPassword('Dummy');
             $user->setEmail('Dummy@Dummy.com');
             $user->setEnabled(true);
             $user->setFirstName('Dummy');
             $user->addRole('ROLE_ADMIN');
             $this->em->persist($user);
             $this->em->flush();
        }
        $this->userDummyEntity = $user;
        return $user;
    }

    protected function tearDown()
    {
        $this->em->close();
        unset($this->client);
    }

}
