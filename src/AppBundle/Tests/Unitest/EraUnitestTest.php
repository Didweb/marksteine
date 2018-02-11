<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Era;
use AppBundle\Controller\CountryController;
use AppBundle\Tests\BaseTesting;

class EraUnitTest extends BaseTesting
{


    private $idEra;





    public function testaddEraOk()
    {
        $this->cleanDummy('Second_Era');
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/era/add-era',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/era/add-era',
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

        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/era/add-era',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/era/delete-era',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/era/delete-era',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/era/edit-era',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/era/edit-era-action',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/era/edit-era-action',
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


    protected function dummyData()
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


}
