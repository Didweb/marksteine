<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Country;
use AppBundle\Controller\CountryController;
use AppBundle\Tests\BaseTesting;

class CountryUnitTest extends Basetesting
{
    private $dummyUser;
    private $idCountry;

    public function testaddCountryError()
    {
        $this->logIn('ROLE_ADMIN');
        $crawler = $this->client->request(
            'POST',
            '/admin/country/add-country',
            array("name" => 'AR', "continent" => 'Nort America and Central America'),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());
        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testaddCountryOk()
    {
        $this->logIn('ROLE_ADMIN');
        $crawler = $this->client->request(
            'POST',
            '/admin/country/add-country',
            array("name" => "DE", "continent" => 'Europe'),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }

    public function testaddCountryNotInList()
    {
        $this->logIn('ROLE_ADMIN');
        $crawler = $this->client->request(
            'POST',
            '/admin/country/add-country',
            array("name" => "XX", "continent" => 'XXXX'),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }

    public function testDeleteCountryOk()
    {
        $this->logIn('ROLE_ADMIN');
        $crawler = $this->client->request(
            'GET',
            '/admin/country/delete-country',
            array("id" => $this->idCountry),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }


    public function testDeleteCountryError()
    {
        $this->logIn('ROLE_ADMIN');
        $crawler = $this->client->request(
            'GET',
            '/admin/country/delete-country',
            array("id" => 99999),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    protected function dummyData()
    {
        $country = $this->em->getRepository('AppBundle:Country')->findOneByName('AR');
        if (!$country) {
             $country = new Country();
             $country->setName('AR');
             $country->setContinent('Nort America and Central America');
             $this->em->persist($country);
             $this->em->flush();
        }
        $countryFail = $this->em->getRepository('AppBundle:Country')->findOneByName('DE');
        if ($countryFail) {
            $this->em->remove($countryFail);
            $this->em->flush();
        }
        $this->idCountry = $country->getId();
        return $country;
    }


}
