<?php
/**
 * Class CheckDate | AppBundle/Services/CheckDate.php
 *
 * @package AppBundle
 * @author Eduard Pinuaga <info@did-web.com>
 */

  namespace AppBundle\Services;

/**
* Transforms numerical data into dates and compares dates.
*/
class CheckDate
{
    private $dateStart;
    private $dateEnd;

    private $yearStart;
    private $yearEnd;

    public function init($dateStart, $dateEnd)
    {
        $explodeDateStart = explode('-', $dateStart);
        $explodeDateEnd   = explode('-', $dateEnd);

        $this->yearStart = $explodeDateStart[2];
        $this->yearEnd   = $explodeDateEnd[2];

        $this->controlYear();

        $this->dateStart = new \DateTime($explodeDateStart[0].'-'.$explodeDateStart[1].$this->yearStart);
        $this->dateEnd   = new \DateTime($explodeDateEnd[0].'-'.$explodeDateEnd[1].$this->yearEnd);
    }


    public function controlYear()
    {

        if ($this->yearStart < $this->yearEnd) {
            $this->yearStart = '-1970';
            $this->yearEnd   = '-1975';
        } elseif ($this->yearStart > $this->yearEnd) {
            $this->yearStart = '-1975';
            $this->yearEnd   = '-1970';
        } else {
            $this->yearStart = '-1970';
            $this->yearEnd   = '-1970';
        }
    }
    /**
     * Check if the date range is correct.
     * The start date (Start) must be less than the final date (End).
     * @return boolean
     */
    public function correctInterval()
    {
        if ($this->dateStart > $this->dateEnd) {
            return false;
        }
        return true;
    }

    public function getYearStart()
    {
        return $this->yearStart;
    }

    public function getYearEnd()
    {
        return $this->yearEnd;
    }

    public function getDateStart()
    {
        return $this->dateStart;
    }

    public function getDateEnd()
    {
        return $this->dateEnd;
    }
}
