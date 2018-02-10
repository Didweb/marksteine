<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Type;
use AppBundle\Controller\CountryController;

class TypeUnitTest extends WebTestCase
{

    private $client = null;
    private $em;
    private $container;
    private $idType;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = static::$kernel->getContainer();
        $this->em = static::$kernel->getContainer()
                              ->get('doctrine')
                              ->getManager();
        $this->dummyData();
    }



    public function testaddTypeOk()
    {
        $this->cleanDummy('Second_Type');

        $crawler = $this->client->request(
            'GET',
            '/type/add-type',
            array("name" => "Second_Type", "color" => "#000000"),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }



    public function testaddTypeErrorColor()
    {
        $this->cleanDummy('Second_Type');

        $crawler = $this->client->request(
            'GET',
            '/type/add-type',
            array("name" => "Second_Type"),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testaddTypeErrorRepeat()
    {

        $crawler = $this->client->request(
            'GET',
            '/type/add-type',
            array("name" => "First_Type", "color" => "#ffffff"),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testRemoveType()
    {

        $crawler = $this->client->request(
            'GET',
            '/type/delete-type',
            array("id" => $this->idType),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }


    public function testRemoveTypeError()
    {
        $crawler = $this->client->request(
            'GET',
            '/type/delete-type',
            array("id" => 99999),
            array(),
            array()
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    public function testEditType()
    {

        $crawler = $this->client->request(
            'POST',
            '/type/edit-type',
            array("id" => $this->idType, "name" => "Second_Typexxx", "color" => "#ffffff"),
            array(),
            array()
        );

        $this->cleanDummy('Second_Typexxx');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());
    }


    public function testEditActType()
    {
        $this->dummyData();

        $crawler = $this->client->request(
            'POST',
            '/type/edit-type-action',
            array("id" => $this->idType, "name" => "Second_Typexxx", "color" => "#ffffff"),
            array(),
            array()
        );

        $this->cleanDummy('Second_Typexxx');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('ok', $objResult->result);
    }


    public function testEditActTypeError()
    {
        $this->dummyData();

        $crawler = $this->client->request(
            'POST',
            '/type/edit-type-action',
            array("id" => $this->idType, "name" => "Second_Typexxx"),
            array(),
            array()
        );

        $this->cleanDummy('Second_Typexxx');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), "Code: ".$this->client->getResponse()->getStatusCode());

        $objResult = json_decode($this->client->getResponse()->getContent());
        $objResult = json_decode($objResult);
        $this->assertEquals('error', $objResult->result);
    }


    private function dummyData()
    {
        $type = $this->em->getRepository('AppBundle:Type')->findOneByName('First_Type');
        if (!$type) {
             $type = new Type();
             $type->setName('First_Type');
             $type->setColor('#000000');
             $this->em->persist($type);
             $this->em->flush();
        }


        $this->idType = $type->getId();
        return $type;
    }


    private function cleanDummy($name)
    {
        $cleanType = $this->em->getRepository('AppBundle:Type')->findOneByName($name);
        if ($cleanType) {
            $this->em->remove($cleanType);
            $this->em->flush();
        }
    }


    protected function tearDown()
    {
        $this->em->close();
        unset($this->client);
    }
}
