<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Type;
use AppBundle\Controller\CountryController;
use AppBundle\Tests\BaseTesting;

class TypeUnitTest extends BaseTesting
{
    private $idType;


    public function testaddTypeOk()
    {
        $this->cleanDummy('Second_Type');
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/type/add-type',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/type/add-type',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/type/add-type',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/type/delete-type',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'GET',
            '/admin/type/delete-type',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/type/edit-type',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/type/edit-type-action',
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
        $this->logIn('ROLE_ADMIN');

        $crawler = $this->client->request(
            'POST',
            '/admin/type/edit-type-action',
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


    protected function dummyData()
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
}
