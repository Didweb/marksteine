<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Entity\Milestone;

class MilestoneUnitTest extends WebTestCase
{

    private $client = null;
    private $em;
    private $container;
    private $idMilestone;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = static::$kernel->getContainer();
        $this->em = static::$kernel->getContainer()
                              ->get('doctrine')
                              ->getManager();
        $this->dummyData();
    }



    public function testaddMilestoneOk()
    {
        $this->cleanDummy('Second_Milestone');
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/milestone/add-milestone',
            array("title" => "Second_Milestone", "description" => "a", "day" => 2, "month" => 3, "year" => 4),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }



    public function testaddMilestoneErrorTitleNull()
    {
        $this->cleanDummy('Second_Milestone');
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/milestone/add-milestone',
            array("title" => null, "description" => "a", "day" => 2, "month" => 3, "year" => 4),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testaddMilestoneErrorRepeat()
    {
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/milestone/add-milestone',
            array("title" => "First_Milestone", "description" => "a", "day" => 2, "month" => 3, "year" => 4),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testRemoveMilestone()
    {
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/milestone/delete-milestone',
            array("id" => $this->idMilestone),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }


    public function testRemoveMilestoneError()
    {
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/milestone/delete-milestone',
            array("id" => 99999),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testEditMilestone()
    {
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/milestone/edit-milestone',
            array("id" => $this->idMilestone, "title" => "Second_Milestonexx", "description" => "description", "day" => 1, "month" => 2, "year" => 3),
            array(),
            array()
        );

        $this->cleanDummy('Second_Milestonexx');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());
    }


    public function testEditActMilestone()
    {
        $this->dummyData();

        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/milestone/edit-milestone-action',
            array("id" => $this->idMilestone, "title" => "Second_Milestonexx", "description" => "description", "day" => 1, "month" => 2, "year" => 3),
            array(),
            array()
        );

        $this->cleanDummy('Second_Milestonexx');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }





    private function dummyData()
    {
        $milestone = $this->em->getRepository('AppBundle:Milestone')->findOneByTitle('First_Milestone');
        if (!$milestone) {
             $milestone = new Milestone();
             $milestone->setTitle('First_Milestone');
             $milestone->setDescription('Description');
             $milestone->setDay(1);
             $milestone->setMonth(2);
             $milestone->setYear(3);
             $this->em->persist($milestone);
             $this->em->flush();
        }


        $this->idMilestone = $milestone->getId();
        return $milestone;
    }


    private function cleanDummy($name)
    {
        $cleanMilestone= $this->em->getRepository('AppBundle:Milestone')->findOneByTitle($name);
        if ($cleanMilestone) {
            $this->em->remove($cleanMilestone);
            $this->em->flush();
        }
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

    protected function tearDown()
    {
        $this->em->close();
        unset($this->client);
    }
}
