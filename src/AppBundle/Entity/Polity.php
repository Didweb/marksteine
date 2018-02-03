<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Polity
 *
 * @ORM\Table(name="polity")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PolityRepository")
 * @UniqueEntity( fields={"name"}, errorPath="polity", message="This era is already added.")
 */
class Polity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150,  nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @ORM\Column(name="yearstart", type="integer",  nullable=false)
     */
    private $yearStart;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @ORM\Column(name="yearend", type="integer",  nullable=false)
     */
    private $yearEnd;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\LessThanOrEqual(31)
     * @Assert\GreaterThan(-1)
     * @ORM\Column(name="dayStart", type="integer",  nullable=false)
     */
    private $dayStart;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\LessThanOrEqual(31)
     * @Assert\GreaterThan(-1)
     * @ORM\Column(name="dayEnd", type="integer",  nullable=false)
     */
    private $dayEnd;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\LessThanOrEqual(12)
     * @Assert\GreaterThan(-1)
     * @ORM\Column(name="monthStart", type="integer",  nullable=false)
     */
    private $monthStart;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\LessThanOrEqual(12)
     * @Assert\GreaterThan(-1)
     * @ORM\Column(name="monthEnd", type="integer",  nullable=false)
     */
    private $monthEnd;

    /**
     * Created At.
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createAt;


    /**
     * Update date.
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\ManyToMany(targetEntity="Country", mappedBy="politices", cascade={"persist"})
     **/
    private $countries;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Polity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Polity
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set yearStart
     *
     * @param integer $yearStart
     *
     * @return Polity
     */
    public function setYearStart($yearStart)
    {
        $this->yearStart = $yearStart;

        return $this;
    }

    /**
     * Get yearStart
     *
     * @return int
     */
    public function getYearStart()
    {
        return $this->yearStart;
    }

    /**
     * Set yearEnd
     *
     * @param integer $yearEnd
     *
     * @return Polity
     */
    public function setYearEnd($yearEnd)
    {
        $this->yearEnd = $yearEnd;

        return $this;
    }

    /**
     * Get yearEnd
     *
     * @return int
     */
    public function getYearEnd()
    {
        return $this->yearEnd;
    }

    /**
     * Set dayStart
     *
     * @param integer $dayStart
     *
     * @return Polity
     */
    public function setDayStart($dayStart)
    {
        $this->dayStart = $dayStart;

        return $this;
    }

    /**
     * Get dayStart
     *
     * @return int
     */
    public function getDayStart()
    {
        return $this->dayStart;
    }

    /**
     * Set dayEnd
     *
     * @param integer $dayEnd
     *
     * @return Polity
     */
    public function setDayEnd($dayEnd)
    {
        $this->dayEnd = $dayEnd;

        return $this;
    }

    /**
     * Get dayEnd
     *
     * @return int
     */
    public function getDayEnd()
    {
        return $this->dayEnd;
    }

    /**
     * Set monthStart
     *
     * @param integer $monthStart
     *
     * @return Polity
     */
    public function setMonthStart($monthStart)
    {
        $this->monthStart = $monthStart;

        return $this;
    }

    /**
     * Get monthStart
     *
     * @return int
     */
    public function getMonthStart()
    {
        return $this->monthStart;
    }

    /**
     * Set monthEnd
     *
     * @param integer $monthEnd
     *
     * @return Polity
     */
    public function setMonthEnd($monthEnd)
    {
        $this->monthEnd = $monthEnd;

        return $this;
    }

    /**
     * Get monthEnd
     *
     * @return int
     */
    public function getMonthEnd()
    {
        return $this->monthEnd;
    }

    /**
     * @param Country|null $country
     */
    public function addCountry(Country $country = null)
    {
        if (!$this->countries->contains($country)) {
            $this->countries->add($country);
            $country->addPolity($this);
        }
    }

    /**
     * @return array
     */
    public function getCountrys()
    {
        return $this->countries->toArray();
    }

    /**
     * @param Country $country
     */
    public function removeCountry(Country $country)
    {
        if (!$this->countries->contains($country)) {
            return;
        }
        $this->countries->removeElement($country);
        $country->removePolity($this);
    }

    /**
     * Remove all countries for this Polity
     */
    public function removeAllCountrys()
    {
        $this->countries->clear();
    }

}
