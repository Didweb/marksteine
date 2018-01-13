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

        $this->dateStart = new \DateTime($explodeDateStart[0].'-'.$explodeDateStart[1].'-1970');
        $this->dateEnd   = new \DateTime($explodeDateEnd[0].'-'.$explodeDateEnd[1].'-1970');

        $this->yearStart = $explodeDateStart[2];
        $this->yearEnd   = $explodeDateEnd[2];
    }

    /**
     * Check if the date range is correct.
     * The start date (Start) must be less than the final date (End).
     * @return boolean
     */
    public function correctInterval()
    {
        if ($this->dateStart > $this->dateEnd
            || $this->yearStart > $this->yearEnd ) {
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
