<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Type
 *
 * @ORM\Table(name="type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeRepository")
 * @UniqueEntity("name")
 */
class Type
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
     * @Assert\NotNull()
     * @ORM\Column(name="name", type="string", length=255, unique=true,  nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @ORM\Column(name="color", type="string", length=15,  nullable=false)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="Milestone", mappedBy="type")
     */
    private $milestones;

    public function __construct()
    {
        $this->milestones = new ArrayCollection();
    }

    /**
     * @return Collection|Milestone[]
     */
    public function getMilestones()
    {
         return $this->milestones;
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
     * @return Type
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
     * Set color
     *
     * @param string $color
     *
     * @return Type
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
}
