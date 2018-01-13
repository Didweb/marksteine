<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Polity;
use AppBundle\Controller\PolityController;

class PolityUnitTest extends WebTestCase
{

    private $client = null;
    private $em;
    private $container;
    private $idPolity;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = static::$kernel->getContainer();
        $this->em = static::$kernel->getContainer()
                              ->get('doctrine')
                              ->getManager();
        $this->dummyData();
    }



    public function testaddPolityOk()
    {
        $this->cleanDummy('Second_Polity');

        $crawler = $this->client->request(
            'GET',
            '/polity/add-polity',
            array("name"        => "Second_Polity",
                  "description" => "Description Second_Polity",
                  "dayStart"    => 1,
                  "dayEnd"      => 2,
                  "monthStart"  => 1,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2),
            array(),
            array()
        );

        $this->assertSame(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Code: ".$this->client->getResponse()->getStatusCode()
        );

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }



    public function testaddPolityErrorStart()
    {
        $this->cleanDummy('Second_Polity');

        $crawler = $this->client->request(
            'GET',
            '/polity/add-polity',
            array("name"        => "Second_Polity",
                  "description" => "Description Second_Polity",
                  "dayStart"    => 5,
                  "dayEnd"      => 2,
                  "monthStart"  => 5,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2),
            array(),
            array()
        );

        $this->assertSame(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Code: ".$this->client->getResponse()->getStatusCode()
        );

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testaddPolityErrorRepeat()
    {

        $crawler = $this->client->request(
            'GET',
            '/polity/add-polity',
            array("name"        => "First_Polity",
                  "description" => "Description First_Polity",
                  "dayStart"    => 1,
                  "dayEnd"      => 2,
                  "monthStart"  => 1,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2),
            array(),
            array()
        );

        $this->assertSame(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Code: ".$this->client->getResponse()->getStatusCode()
        );

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testRemovePolity()
    {

        $crawler = $this->client->request(
            'GET',
            '/polity/delete-polity',
            array("id" => $this->idPolity),
            array(),
            array()
        );

        $this->assertSame(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Code: ".$this->client->getResponse()->getStatusCode()
        );

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }


    public function testRemovePolityError()
    {
        $crawler = $this->client->request(
            'GET',
            '/polity/delete-polity',
            array("id" => 99999),
            array(),
            array()
        );

        $this->assertSame(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Code: ".$this->client->getResponse()->getStatusCode()
        );

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testEditPolity()
    {

        $crawler = $this->client->request(
            'POST',
            '/polity/edit-polity',
            array("id" => $this->idPolity,
                  "name"        => "Second_Polity_False",
                  "description" => "Description Second_Polity_False",
                  "dayStart"    => 1,
                  "dayEnd"      => 2,
                  "monthStart"  => 1,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2),
            array(),
            array()
        );

        $this->cleanDummy('Second_Polity_False');

        $this->assertSame(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Code: ".$this->client->getResponse()->getStatusCode()
        );
    }


    public function testEditActPolity()
    {
        $this->dummyData();

        $crawler = $this->client->request(
            'POST',
            '/polity/edit-polity-action',
            array("id" => $this->idPolity,
                  "name"        => "Second_Polity_False",
                  "description" => "Description Second_Polity_False",
                  "dayStart"    => 1,
                  "dayEnd"      => 2,
                  "monthStart"  => 1,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2),
            array(),
            array()
        );

        $this->cleanDummy('Second_Polity_False');

        $this->assertSame(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Code: ".$this->client->getResponse()->getStatusCode()
        );

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }


    public function testEditActPolityError()
    {
        $this->dummyData();

        $crawler = $this->client->request(
            'POST',
            '/polity/edit-polity-action',
            array("id" => $this->idPolity,
                  "name"        => "Second_Polity_False",
                  "description" => "Description Second_Polity_False",
                  "dayStart"    => 5,
                  "dayEnd"      => 2,
                  "monthStart"  => 5,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2),
            array(),
            array()
        );

        $this->cleanDummy('Second_Polity_False');

        $this->assertSame(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Code: ".$this->client->getResponse()->getStatusCode()
        );

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }

    
    public function testEditActPolityErrorIdIncorrect()
    {
        $this->dummyData();

        $crawler = $this->client->request(
            'POST',
            '/polity/edit-polity-action',
            array("id" => 99999,
                  "name"        => "Second_Polity_False",
                  "description" => "Description Second_Polity_False",
                  "dayStart"    => 1,
                  "dayEnd"      => 2,
                  "monthStart"  => 1,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2),
            array(),
            array()
        );



        $this->assertSame(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Code: ".$this->client->getResponse()->getStatusCode()
        );

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }

    private function dummyData()
    {
        $polity = $this->em->getRepository('AppBundle:Polity')->findOneByName('First_Polity');
        if (!$polity) {
             $polity = new Polity();
             $polity->setName('First_Polity');
             $polity->setDescription('Description First_Polity');
             $polity->setDayStart(1);
             $polity->setDayEnd(2);
             $polity->setMonthStart(1);
             $polity->setMonthEnd(2);
             $polity->setYearStart(1);
             $polity->setYearEnd(2);
             $this->em->persist($polity);
             $this->em->flush();
        }

        $this->idPolity = $polity->getId();
        return $polity;
    }


    private function cleanDummy($name)
    {
        $cleanPolity = $this->em->getRepository('AppBundle:Polity')->findOneByName($name);
        if ($cleanPolity) {
            $this->em->remove($cleanPolity);
            $this->em->flush();
        }
    }


    protected function tearDown()
    {
        $this->em->close();
        unset($this->client);
    }
}
