<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CountryRepository")
 * @UniqueEntity( fields={"name"}, errorPath="country", message="This country is already added.")
 */
class Country
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
     * @ORM\Column(name="name", type="string", length=2, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="continent", type="string", length=100, unique=false)
     */
    private $continent;


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
     * @ORM\ManyToMany(targetEntity="Polity", inversedBy="countries", cascade={"persist"})
     * @ORM\JoinTable(name="countries_politices")
     **/
    private $politices;


    public function __construct()
    {
          $this->politices = new ArrayCollection();
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
     * @return Country
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
     * Set continent
     *
     * @param string $continent
     *
     * @return Country
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;

        return $this;
    }

    /**
     * Get contienent
     *
     * @return string
     */
    public function getContienent()
    {
        return $this->continent;
    }


    /**
     * @param Polity $polity
     */
    public function addPolity(Polity $polity)
    {
        if (!$this->politices->contains($polity)) {
            $this->politices->add($polity);
            $polity->addCountry($this);
        }
    }

    /**
     * @return array
     */
    public function getPolitys()
    {
        return $this->politices->toArray();
    }

    /**
     * @param Polity $polity
     */
    public function removePolity(Polity $polity)
    {
        if (!$this->politices->contains($polity)) {
            return;
        }
        $this->politices->removeElement($polity);
        $polity->removeCountry($this);
    }

    /**
     * Remove all articles for this tag
     */
    public function removeAllPolitys()
    {
        $this->politices->clear();
    }
}
