<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Tests\BaseTesting;
use AppBundle\Entity\Profile;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class ProfileControllerTest extends BaseTesting
{
    private $dummyUser;

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



    public function testRemoveAvatar()
    {
        $user = $this->userDummy();
        $user->setAvatar('avatarDummy.jpeg');
        copy('web/avatars/test.jpeg', 'web/avatars/avatarDummy.jpeg');
        $this->em->persist($user);
        $this->em->flush();

        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('security.login.submit')->form();
        $crawler = $this->client->submit($form, array('_username' => 'Dummy', '_password' => 'Dummy'));

        $crawler = $this->client->request('GET', '/profile/remove-avatar/'.$user->getId());

        $this->assertSame(302, $this->client->getResponse()->getStatusCode(), 'code: '.$this->client->getResponse()->getStatusCode());
    }


    public function testEditProfile()
    {
        $user = $this->userDummy();

        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('security.login.submit')->form();
        $crawler = $this->client->submit($form, array('_username' => 'Dummy', '_password' => 'Dummy'));

        $photo = new UploadedFile(
            'web/avatars/test.jpeg',
            'test.jpg',
            'image/jpeg',
            123
        );
        $crawler = $this->client->request('GET', '/profile/edit');
        $form = $crawler->selectButton('Edit')->form();
        $crawler = $this->client->submit(
            $form,
            array('appbundle_user[firstName]' => 'TestMe',
                    'appbundle_user[file]' => $photo)
        );

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }


    /**
     * Created User Dummy
     */
    private function userDummy()
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

        return $user;
    }
}
