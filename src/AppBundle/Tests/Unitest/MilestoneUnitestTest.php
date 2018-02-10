<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\BaseTesting;
use AppBundle\Entity\Milestone;
use AppBundle\Entity\Type;
use AppBundle\Entity\Country;

class MilestoneUnitTest extends BaseTesting
{

    private $idMilestone;
    private $idType;
    private $idCountry;


    public function testaddMilestoneOk()
    {
        $this->cleanDummy('Second_Milestone');
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/milestone/add-milestone',
            array("title" => "Second_Milestone",
                  "description" => "a",
                  "type" => $this->idType,
                  "country" => $this->idCountry,
                  "day" => 2,
                  "month" => 3,
                  "year" => 4),
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
            array(
                  "title"       => null,
                  "description" => "a",
                  "type"        => $this->idType,
                  "country"     => $this->idCountry,
                  "day"         => 2,
                  "month"       => 3,
                  "year"        => 4),
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
            array("title" => "First_Milestone",
            "description" => "a",
            "type" => $this->idType,
            "country" => $this->idCountry,
            "day" => 2,
            "month" => 3,
            "year" => 4),
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
            array(
                  "id" => $this->idMilestone,
                  "title" => "Second_Milestonexx",
                  "description" => "description",
                  "type" => $this->idType,
                  "country" => $this->idCountry,
                  "day" => 1,
                  "month" => 2,
                  "year" => 3),
            array(),
            array()
        );

        $this->cleanDummy('Second_Milestonexx');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }


    protected function dummyData()
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

        $type = $this->em->getRepository('AppBundle:Type')->findOneByName('Test_type');
        if (!$type) {
            $type = new Type();
            $type->setName('Test_type');
            $type->setColor('#000000');
            $this->em->persist($type);
            $this->em->flush();
        }

        $country = $this->em->getRepository('AppBundle:Country')->findOneByname('TT');
        if (!$country) {
            $country = new Country();
            $country->setName('TT');
            $country->setContinent('continent test');
            $this->em->persist($country);
            $this->em->flush();
        }

        $this->idType       = $type->getId();
        $this->idCountry    = $country->getId();
        $this->idMilestone  = $milestone->getId();
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

}
