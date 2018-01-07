<?php
/**
 * Class CountriesContinents | AppBundle/Services/CountriesContinents.php
 *
 * @package AppBundle
 * @author Eduard Pinuaga <info@did-web.com>
 */

  namespace AppBundle\Services;

/**
* CountriesContinents Service: Relate countries by continents.
* Find the code of a country and return to the continent that belongs.
*/
class CountriesContinents
{
    /** @var listCountries */
    private $listCountries;

    public function __construct()
    {
        $this->listCountries = $this->getListCountries();
    }

    /**
     * Returns the continent to which the last country belongs as a parameter.
     * If you can not find it, return null.
     * @param string $codeCountry Code of the country from which we want to obtain the continent.
     * @return null|string  Correct return string (name Continent), Incorrect return null
     */
    public function getContinent($codeCountry)
    {
        $result = "";
        foreach ($this->listCountries as $nameContinent => $listCountry) {
            if (in_array($codeCountry, $listCountry)) {
                return $nameContinent;
            }
        }

        return null;
    }


    public function getCountCountries()
    {
        $n = 0;
        foreach ($this->listCountries as $nameContinent => $listCountry) {
            foreach ($listCountry as $value) {
                $n++;
            }
        }
        return $n;
    }


    private function getListCountries()
    {
        $countries = array(
        'Europe' => array(
              "AL", "DE", "AD", "AM", "AT", "AZ", "BE", "BY", "BA", "BG", "CY",
              "VA", "HR", "DK", "SK", "SI", "ES", "EE", "FI", "FR", "GE", "GR",
              "HU", "IE", "IS", "IT", "XK", "LV", "LI", "LT", "LU", "MK", "MT",
              "MD", "MC", "ME", "NO", "NL", "PL", "PT", "UK", "CZ", "RO", "RU",
              "SM", "SE", "CH", "TR", "UA", "YU", "EZ", "FO", "GI", "GG", "IM",
              "JE", "RS", "SJ", "GB", "AX"
              ),
        "Africa" => array(
              "AO", "DZ", "BJ", "BW", "BF", "BI", "CM", "CV", "TD", "KM", "CG",
              "CD", "CI", "EG", "ER", "ET", "GA", "GM", "GH", "GN", "GW", "GQ",
              "KE", "LS", "LR", "LY", "MG", "MW", "ML", "MA", "MU", "MR", "MZ",
              "NA", "NE", "NG", "CF", "ZA", "RW", "EH", "ST", "SN", "SC", "SL",
              "SO", "SD", "SS", "SZ", "TZ", "TG", "TN", "UG", "DJ", "ZM", "ZW",
              "IO", "IC", "EA", "TF", "YT", "RE", "SH", "TA"
              ),
        "Oceania" => array(
              "AU", "FM", "FJ", "KI", "MH", "SB", "NR", "NZ", "PW", "PG", "WS",
              "TO", "TV", "VU", "CX", "CK", "PF", "GU", "NC", "NU", "NF", "MP",
              "PN", "TL", "TK", "WF"
              ),
        "South America" => array(
              "AR", "BO", "BR", "CL", "CO", "EC", "GY", "PY", "PE", "SR", "TT",
              "UY", "VE", "AW", "AC", "CW", "FK", "GF", "GS"
              ),
        "Nort America and Central America" => array(
              "AG", "BS", "BB", "BZ", "CA", "CR", "CU", "DM", "SV", "US", "GD",
              "GT", "HT", "HN", "JM", "MX", "NI", "PA", "PR", "DO", "KN", "VC",
              "LC", "AS", "AI", "BM", "VG", "BQ", "KY", "CC", "GL", "GP", "MQ",
              "MS", "SX", "BL", "MF", "PM", "TC", "UM", "VI", "UN"
              ),
        "Asia" => array(
              "AF", "SA", "BH", "BD", "MM", "BT", "BN", "KH", "CN", "KP", "KR",
              "AE", "PH", "IN", "ID", "IQ", "IR", "IL", "JP", "JO", "KZ", "KG",
              "KW", "LA", "LB", "MY", "MV", "MN", "NP", "OM", "PK", "QA", "SG",
              "SY", "LK", "TJ", "TH", "TP", "TM", "UZ", "VN", "YE", "DG", "HK",
              "MO", "PS", "TW"
            ),
        "Antartica" => array (
          "AQ"
        )
          );

        return $countries;
    }
}
