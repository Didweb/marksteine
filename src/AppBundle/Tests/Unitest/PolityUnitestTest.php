<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Polity;
use AppBundle\Entity\Country;
use AppBundle\Controller\PolityController;
use AppBundle\Tests\BaseTesting;

class PolityUnitTest extends BaseTesting
{
    private $idPolity;
    private $countryDummy;


    public function testaddPolityOk()
    {
        $this->cleanDummy('Second_Polity');
        $this->logIn('ROLE_ADMIN');
        $crawler = $this->client->request(
            'GET',
            '/admin/polity/add-polity',
            array("name"        => "Second_Polity",
                  "description" => "Description Second_Polity",
                  "dayStart"    => 1,
                  "dayEnd"      => 2,
                  "monthStart"  => 1,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2,
                  "countries" => array($this->countryDummy->getID())),
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/polity/add-polity',
            array("name"        => "Second_Polity",
                  "description" => "Description Second_Polity",
                  "dayStart"    => 5,
                  "dayEnd"      => 2,
                  "monthStart"  => 5,
                  "monthEnd"    => 2,
                  "yearStart"   => 2,
                  "yearEnd"     => 2,
                  "countries" => array($this->countryDummy->getID())),
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/polity/add-polity',
            array("name"        => "First_Polity",
                  "description" => "Description First_Polity",
                  "dayStart"    => 1,
                  "dayEnd"      => 2,
                  "monthStart"  => 1,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2,
                  "countries" => array($this->countryDummy->getID())),
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/polity/delete-polity',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/polity/delete-polity',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/polity/edit-polity',
            array("id" => $this->idPolity,
                  "name"        => "Second_Polity_False",
                  "description" => "Description Second_Polity_False",
                  "dayStart"    => 1,
                  "dayEnd"      => 2,
                  "monthStart"  => 1,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2,
                  "countries" => array($this->countryDummy->getID())),
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/polity/edit-polity-action',
            array("id" => $this->idPolity,
                  "name"        => "Second_Polity_False",
                  "description" => "Description Second_Polity_False",
                  "dayStart"    => 1,
                  "dayEnd"      => 2,
                  "monthStart"  => 1,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2,
                  "countries" => array($this->countryDummy->getID())),
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/polity/edit-polity-action',
            array("id" => $this->idPolity,
                  "name"        => "Second_Polity_False",
                  "description" => "Description Second_Polity_False",
                  "dayStart"    => 5,
                  "dayEnd"      => 2,
                  "monthStart"  => 5,
                  "monthEnd"    => 2,
                  "yearStart"   => 2,
                  "yearEnd"     => 2,
                  "countries" => array($this->countryDummy->getID())),
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/polity/edit-polity-action',
            array("id" => 99999,
                  "name"        => "Second_Polity_False",
                  "description" => "Description Second_Polity_False",
                  "dayStart"    => 1,
                  "dayEnd"      => 2,
                  "monthStart"  => 1,
                  "monthEnd"    => 2,
                  "yearStart"   => 1,
                  "yearEnd"     => 2,
                  "countries" => array($this->countryDummy->getID())),
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


    protected function dummyData()
    {
        $country = $this->em->getRepository('AppBundle:Country')->findOneByName('DE');
        if (!$country) {
            $country = new Country();
            $country->setName('DE');

            $serviceContinent = $this->container->get('app.countries_continents');
            $nameContinent = $serviceContinent->getContinent($country->getName());
            $country->setContinent($nameContinent);

            $this->em->persist($country);
            $this->em->flush();
        }
        $this->countryDummy = $country;

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
             $polity->addCountry($country);
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
}
