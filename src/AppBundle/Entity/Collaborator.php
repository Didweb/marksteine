<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\Publisher;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Collaborator
 *
 * @ORM\Table(name="collaborator")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CollaboratorRepository")
 */
class Collaborator extends Publisher
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


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
     * Get id
     *
     * @return int
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}
