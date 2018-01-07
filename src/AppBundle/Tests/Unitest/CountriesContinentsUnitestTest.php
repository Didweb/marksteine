<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Services\CountriesContinents;

class CountriesContinentsUnitTest extends WebTestCase
{


    public function testFindContinentOk()
    {
        $countriesContinents = new CountriesContinents();

        $testEuropa = $countriesContinents->getContinent("ES");
        $this->assertEquals('Europe', $testEuropa);

        $testEuropa = $countriesContinents->getContinent("BI");
        $this->assertEquals('Africa', $testEuropa);

        $testEuropa = $countriesContinents->getContinent("KI");
        $this->assertEquals('Oceania', $testEuropa);

        $testEuropa = $countriesContinents->getContinent("CO");
        $this->assertEquals('South America', $testEuropa);

        $testEuropa = $countriesContinents->getContinent("PA");
        $this->assertEquals('Nort America and Central America', $testEuropa);

        $testEuropa = $countriesContinents->getContinent("IN");
        $this->assertEquals('Asia', $testEuropa);
    }

    public function testControlListing()
    {
        $countListSelect = $listAllCountries = $this->getListControl();
        $countListSelect = count($countListSelect);

        $countriesContinents = new CountriesContinents();
        $countListService = $countriesContinents->getCountCountries();

        $this->assertEquals(255, $countListSelect, "Select: ".$countListSelect);
        $this->assertEquals(258, $countListService, "Service: ".$countListService);
    }


    public function testAllCountries()
    {
        $countriesContinents = new CountriesContinents();

        $listAllCountries = $this->getListControl();

        foreach ($listAllCountries as $key => $country) {
            $testCountry = $countriesContinents->getContinent($country);
            $this->assertNotNull($testCountry, "Country ".$country." ist Null.");
        }
    }


    public function testFindContinentError()
    {
        $countriesContinents = new CountriesContinents();

        $testEuropa = $countriesContinents->getContinent("XX");
        $this->assertNull($testEuropa);
    }

    private function getListControl()
    {

        $listAllCountries = array("AF" , "AL" , "DZ" , "AS" , "AD" , "AO" , "AI" ,
        "AQ" , "AG" , "AR" , "AM" , "AW" , "AC" , "AU" , "AT" , "AZ" , "BS" ,
        "BH" , "BD" , "BB" , "BY" , "BE" , "BZ" , "BJ" , "BM" , "BT" , "BO" ,
        "BA" , "BW" , "BR" , "IO" , "VG" , "BN" , "BG" , "BF" , "BI" , "KH" ,
        "CM" , "CA" , "IC" , "CV" , "BQ" , "KY" , "CF" , "EA"  , "TD" , "CL" ,
        "CN" , "CX" , "CC" , "CO" , "KM" , "CG" , "CD" , "CK" , "CR" , "HR",
        "CU" , "CW" , "CY" , "CZ" , "CI" , "DK" , "DG" , "DJ" , "DM" , "DO" , "EC" ,
        "EG" , "SV" , "GQ" , "ER" , "EE" , "ET" , "EZ" , "FK" , "FO" , "FJ" , "FI" ,
        "FR" , "GF" , "PF" , "TF" , "GA" , "GM" , "GE" , "DE" , "GH" , "GI" , "GR" ,
        "GL" , "GD" , "GP" , "GU" , "GT" , "GG" , "GN" , "GW" , "GY" , "HT" , "HN" ,
        "HK" , "HU" , "IS" , "IN" , "ID" , "IR" , "IQ" , "IE" , "IM" , "IL" ,
        "IT" , "JM" , "JP" , "JE" , "JO" , "KZ" , "KE" , "KI" , "XK" , "KW" , "KG" ,
        "LA" , "LV" , "LB" , "LS" , "LR" , "LY" , "LI" , "LT" , "LU" , "MO" ,
        "MK" , "MG" , "MW" , "MY" , "MV" , "ML" , "MT" , "MH" , "MQ" , "MR" , "MU" ,
        "YT" , "MX" , "FM" , "MD" , "MC" , "MN" , "ME" , "MS" , "MA" , "MZ" , "MM" ,
        "NA" , "NR" , "NP" , "NL" , "NC" , "NZ" , "NI" , "NE" , "NG" , "NU" , "NF" ,
        "KP" , "MP" , "NO" , "OM" , "PK" , "PW" , "PS" , "PA" , "PG", "PY" ,
        "PE" , "PH" , "PN" , "PL" , "PT" , "PR" , "QA" , "RO" , "RU" , "RW" , "RE" ,
        "WS" , "SM" , "SA" , "SN" , "RS" , "SC" , "SL" , "SG" , "SX" , "SK" , "SI" ,
        "SB" , "SO" , "ZA" , "GS" , "KR" , "SS" , "ES" , "LK" , "BL" , "SH" , "KN" ,
        "LC" , "MF" , "PM" , "VC" , "SD" , "SR" , "SJ" , "SZ" , "SE" , "CH" ,
        "SY" , "ST" , "TW" , "TJ" , "TZ" , "TH" , "TL" , "TG" , "TK" , "TO" , "TT" ,
        "TA" , "TN" , "TR" , "TM" , "TC" , "TV" , "UM" , "VI" , "UG" , "UA" ,
        "AE" , "GB" , "UN" , "US" , "UY" , "UZ" , "VU" , "VA" , "VE" , "VN" , "WF" ,
        "EH" , "YE" , "ZM" , "ZW" , "AX" );

        return $listAllCountries;
    }
}
