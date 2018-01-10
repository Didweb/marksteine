<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Polity
 *
 * @ORM\Table(name="polity")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PolityRepository")
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true, unique=true)
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
     * @ORM\Column(name="yearstart", type="integer")
     */
    private $yearStart;

    /**
     * @var int
     *
     * @ORM\Column(name="yearend", type="integer")
     */
    private $yearEnd;

    /**
     * @var int
     *
     * @Assert\LessThanOrEqual(31)
     * @Assert\GreaterThan(1)
     * @ORM\Column(name="dayStart", type="integer")
     */
    private $dayStart;

    /**
     * @var int
     *
     * @Assert\LessThanOrEqual(31)
     * @Assert\GreaterThan(1)
     * @ORM\Column(name="dayEnd", type="integer")
     */
    private $dayEnd;

    /**
     * @var int
     *
     * @Assert\LessThanOrEqual(12)
     * @Assert\GreaterThan(1)
     * @ORM\Column(name="monthStart", type="integer")
     */
    private $monthStart;

    /**
     * @var int
     *
     * @Assert\LessThanOrEqual(12)
     * @Assert\GreaterThan(1)
     * @ORM\Column(name="monthEnd", type="integer")
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
}
