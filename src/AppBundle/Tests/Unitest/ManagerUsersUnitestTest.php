<?php

namespace AppBundle\Tests\Controller;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Services\ManagerUsers;
use AppBundle\Entity\User;


class ManagerUsersUnitTest extends WebTestCase
{
    private $userManager;
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


    public function testUserManagerOkresultOk()
    {
        $this->userManager = $this->createUserDummy("ROLE_MANAGER", "UserManager");
        $userObject = $this->createUserDummy("ROLE_MANAGER", "UserObject");

        $managerUsers = new ManagerUsers($this->em, $this->container);
        $result = $managerUsers->changeRole(1, 2, $userObject->getId(), $this->userManager);
        $objResult = json_decode($result);
        $this->assertEquals('ok', $objResult->result);
    }


    public function testUserManagerOkresultOkCheckRole()
    {
        $this->userManager = $this->createUserDummy("ROLE_MANAGER", "UserManager");
        $userObject = $this->createUserDummy("ROLE_MANAGER", "UserObject");

        $managerUsers = new ManagerUsers($this->em, $this->container);

        // 5 =  "ROLE_SUPER_ADMIN"
        $result = $managerUsers->changeRole(4, 3, $userObject->getId(), $this->userManager);
        $objResult = json_decode($result);
        $this->assertEquals('ok', $objResult->result);
        $this->assertContains('ROLE_SUPER_ADMIN', $userObject->getRoles());
    }

    public function testUserManagerKOEqualIduserIdManager()
    {
        $this->userManager = $this->createUserDummy("ROLE_MANAGER", "UserManager");
        $userObject = $this->createUserDummy("ROLE_MANAGER", "UserObject");

        $managerUsers = new ManagerUsers($this->em, $this->container);

        // 5 =  "ROLE_SUPER_ADMIN"
        $result = $managerUsers->changeRole(5, 3, $this->userManager->getId(), $this->userManager);
        $objResult = json_decode($result);
        $this->assertEquals('error', $objResult->result);
    }


    public function testUserManagerOkresultKO()
    {
        $this->userManager = $this->createUserDummy("ROLE_USER", "UserManager");
        $userObject = $this->createUserDummy("ROLE_MANAGER", "UserObject");

        $managerUsers = new ManagerUsers($this->em, $this->container);
        $result = $managerUsers->changeRole(1, 2, $userObject->getId(), $this->userManager);
        $objResult = json_decode($result);
        $this->assertEquals('error', $objResult->result);
    }


    public function testUserManagerOk()
    {
        $this->userManager = $this->createUserDummy("ROLE_MANAGER", "UserManager");
        $managerUsers = new ManagerUsers($this->em, $this->container);
        $managerUsers->controlManager($this->userManager);
        $this->assertTrue($managerUsers->getIsUserManager());
    }

    public function testUserManagerOkAdmin()
    {
        $this->userManager = $this->createUserDummy("ROLE_ADMIN", "UserManager");
        $managerUsers = new ManagerUsers($this->em, $this->container);
        $managerUsers->controlManager($this->userManager);
        $this->assertTrue($managerUsers->getIsUserManager());
    }

    public function testUserManagerOkSuperAdmin()
    {
        $this->userManager = $this->createUserDummy("ROLE_SUPER_ADMIN", "UserManager");
        $managerUsers = new ManagerUsers($this->em, $this->container);
        $managerUsers->controlManager($this->userManager);
        $this->assertTrue($managerUsers->getIsUserManager());
    }

    public function testUserManagerKOCollaborator()
    {
        $this->userManager = $this->createUserDummy("ROLE_COLLABORATOR", "UserManager");
        $managerUsers = new ManagerUsers($this->em, $this->container);
        $managerUsers->controlManager($this->userManager);
        $this->assertFalse($managerUsers->getIsUserManager());
    }


    public function testUserManagerKOUser()
    {
        $this->userManager = $this->createUserDummy("ROLE_USER", "UserManager");
        $managerUsers = new ManagerUsers($this->em, $this->container);
        $managerUsers->controlManager($this->userManager);
        $this->assertFalse($managerUsers->getIsUserManager());
    }

    public function createUserDummy($role, $name)
    {
        $user = $this->em->getRepository('AppBundle:User')->findOneByUsername($name);
        if ($user) {
            $this->em->remove($user);
            $this->em->flush();
        }

        $user = new User();
        $user->setUsername($name);
        $user->setPlainPassword($name);
        $user->setEmail($name.'@'.$name.'.com');
        $user->setEnabled(true);
        $user->setFirstName($name);
        $user->addRole($role);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }



}
