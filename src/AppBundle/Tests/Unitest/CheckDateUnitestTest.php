<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Services\CheckDate;

class CheckDateUnitTest extends WebTestCase
{
    private $serviceCheckDate;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = static::$kernel->getContainer();
        $this->serviceCheckDate = static::$kernel->getContainer()
                              ->get('app.check_date');
    }

    public function testCheckDataIntegrity()
    {
        $dateStart = '1-12-2015';
        $dateEnd = '2-12-2015';

        $this->serviceCheckDate->init($dateStart, $dateEnd);
        $dateStartService =   $this->serviceCheckDate->getDateStart();
        $dateEndService   =   $this->serviceCheckDate->getDateEnd();

        $this->assertInternalType('object', $dateStartService);
        $this->assertEquals('DateTime', get_class($dateStartService));
        $this->assertEquals('1-12-1970', $dateStartService->format('j-m-Y'));

        $this->assertInternalType('object', $dateEndService);
        $this->assertEquals('DateTime', get_class($dateEndService));
        $this->assertEquals('2-12-1970', $dateEndService->format('j-m-Y'));
    }

    public function testCorrectIntervalTrue()
    {
        $dateStart = '2-1-2015';
        $dateEnd   = '2-5-2016';
        $this->serviceCheckDate->init($dateStart, $dateEnd);
        $result =  $this->serviceCheckDate->correctInterval();
        $this->assertTrue($result);
        $this->assertEquals('-1970', $this->serviceCheckDate->getYearStart());
        $this->assertEquals('-1975', $this->serviceCheckDate->getYearEnd());
    }

    public function testCorrectIntervalFalseDay()
    {
        $dateStart = '10-5-2015';
        $dateEnd   = '2-5-2015';
        $this->serviceCheckDate->init($dateStart, $dateEnd);
        $result =  $this->serviceCheckDate->correctInterval();
        $this->assertFalse($result);
    }

    public function testCorrectIntervalFalseMonth()
    {
        $dateStart = '2-10-2015';
        $dateEnd   = '2-5-2015';
        $this->serviceCheckDate->init($dateStart, $dateEnd);
        $result =  $this->serviceCheckDate->correctInterval();
        $this->assertFalse($result);
    }

    public function testCorrectIntervalFalseYear()
    {
        $dateStart = '2-1-2020';
        $dateEnd   = '2-5-2015';
        $this->serviceCheckDate->init($dateStart, $dateEnd);
        $result =  $this->serviceCheckDate->correctInterval();
        $this->assertFalse($result);
    }

}
