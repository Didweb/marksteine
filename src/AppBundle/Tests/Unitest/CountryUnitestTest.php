<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Country;
use AppBundle\Controller\CountryController;

class CountryUnitTest extends WebTestCase
{

    private $client = null;
    private $dummyUser;
    private $em;
    private $container;
    private $idCountry;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = static::$kernel->getContainer();
        $this->em = static::$kernel->getContainer()
                              ->get('doctrine')
                              ->getManager();
        $this->dummyData();
    }


    public function testaddCountryError()
    {
        $crawler = $this->client->request(
            'POST',
            '/country/add-country',
            array("name"        => 'AR'),
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
        $crawler = $this->client->request(
            'POST',
            '/country/add-country',
            array("name" => "XX"),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }


    public function testDeleteCountryOk()
    {
        $crawler = $this->client->request(
            'GET',
            '/country/delete-country',
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
        $crawler = $this->client->request(
            'GET',
            '/country/delete-country',
            array("id" => 99999),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    private function dummyData()
    {
        $country = $this->em->getRepository('AppBundle:Country')->findOneByName('AR');
        if (!$country) {
             $country = new Country();
             $country->setName('AR');
             $this->em->persist($country);
             $this->em->flush();
        }
        $countryFail = $this->em->getRepository('AppBundle:Country')->findOneByName('XX');
        if ($countryFail) {
            $this->em->remove($countryFail);
            $this->em->flush();
        }
        $this->idCountry = $country->getId();
        return $country;
    }


    protected function tearDown()
    {
        $this->em->close();
        unset($this->client);
    }
}
