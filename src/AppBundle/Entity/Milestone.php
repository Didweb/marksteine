<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\Type;

/**
 * Milestone
 *
 * @ORM\Table(name="milestone")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MilestoneRepository")
 * @UniqueEntity("title")
 */
class Milestone
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     * @Assert\NotNull()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotNull()
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="day", type="integer")
     * @Assert\NotNull()
     */
    private $day;

    /**
     * @var int
     *
     * @ORM\Column(name="month", type="integer")
     * @Assert\NotNull()
     */
    private $month;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     * @Assert\NotNull()
     */
    private $year;


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
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="milestones")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $type;


    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="milestones")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $country;

    public function getCountry()
    {
        return $this->country;
    }


    public function setCountry(Country $country)
    {
        $this->country = $country;
    }


    public function getType()
    {
        return $this->type;
    }


    public function setType(Type $type)
    {
        $this->type = $type;
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
     * Set title
     *
     * @param string $title
     *
     * @return Milestone
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Milestone
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
     * Set day
     *
     * @param integer $day
     *
     * @return Milestone
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set month
     *
     * @param integer $month
     *
     * @return Milestone
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Milestone
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }
}
