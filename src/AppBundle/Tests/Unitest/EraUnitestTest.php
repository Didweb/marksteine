<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Era;
use AppBundle\Controller\CountryController;

class EraUnitTest extends WebTestCase
{

    private $client = null;
    private $em;
    private $container;
    private $idEra;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = static::$kernel->getContainer();
        $this->em = static::$kernel->getContainer()
                              ->get('doctrine')
                              ->getManager();
        $this->dummyData();
    }



    public function testaddEraOk()
    {
        $this->cleanDummy('Second_Era');

        $crawler = $this->client->request(
            'GET',
            '/era/add-era',
            array("name" => "Second_Era", "start" => 1, "end" => 2),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }



    public function testaddEraErrorStart()
    {
        $this->cleanDummy('Second_Era');

        $crawler = $this->client->request(
            'GET',
            '/era/add-era',
            array("name" => "Second_Era", "start" => 2, "end" => 2),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testaddEraErrorRepeat()
    {

        $crawler = $this->client->request(
            'GET',
            '/era/add-era',
            array("name" => "First_Era", "start" => 2, "end" => 2),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testRemoveEra()
    {

        $crawler = $this->client->request(
            'GET',
            '/era/delete-era',
            array("id" => $this->idEra),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }


    public function testRemoveEraError()
    {
        $crawler = $this->client->request(
            'GET',
            '/era/delete-era',
            array("id" => 99999),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testEditEra()
    {

        $crawler = $this->client->request(
            'POST',
            '/era/edit-era',
            array("id" => $this->idEra, "name" => "Second_Eraxx", "start" => 1, "end" => 2),
            array(),
            array()
        );

        $this->cleanDummy('Second_Eraxx');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());
    }


    public function testEditActEra()
    {
        $this->dummyData();

        $crawler = $this->client->request(
            'POST',
            '/era/edit-era-action',
            array("id" => $this->idEra, "name" => "Second_Eraxx", "start" => 1, "end" => 2),
            array(),
            array()
        );

        $this->cleanDummy('Second_Eraxx');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }


    public function testEditActEraError()
    {
        $this->dummyData();

        $crawler = $this->client->request(
            'POST',
            '/era/edit-era-action',
            array("id" => $this->idEra, "name" => "Second_Eraxx", "start" => 3, "end" => 2),
            array(),
            array()
        );

        $this->cleanDummy('Second_Eraxx');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    private function dummyData()
    {
        $era = $this->em->getRepository('AppBundle:Era')->findOneByName('First_Era');
        if (!$era) {
             $era = new Era();
             $era->setName('First_Era');
             $era->setStart(1);
             $era->setEnd(2);
             $this->em->persist($era);
             $this->em->flush();
        }


        $this->idEra = $era->getId();
        return $era;
    }


    private function cleanDummy($name)
    {
        $cleanEra = $this->em->getRepository('AppBundle:Era')->findOneByName($name);
        if ($cleanEra) {
            $this->em->remove($cleanEra);
            $this->em->flush();
        }
    }


    protected function tearDown()
    {
        $this->em->close();
        unset($this->client);
    }
}
