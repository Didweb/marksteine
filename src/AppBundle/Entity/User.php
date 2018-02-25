<?php
/**
 * Class User | AppBundle/Entity/User.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
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
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1, nullable=true)
     */
    protected $gender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="brithdate", type="datetime", nullable=true)
     */
    protected $brithdate;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    protected $country;

    /**
      * @Assert\File(maxSize="6000000")
      */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    protected $avatar;


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
     * @ORM\OneToMany(targetEntity="Milestone", mappedBy="createdBy")
     */
    private $milestones;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="collaborators", cascade={"remove"})
     * @ORM\JoinColumn(name="manager", referencedColumnName="id")
     */
    private $manager;


    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="manager", cascade={"remove"})
     */
    private $collaborators;


    /*
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->milestones = new ArrayCollection();
        $this->collaborators = new ArrayCollection();
    }


    /**
     * Set manager
     *
     * @param User $manager
     *
     * @return User
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Get manager
     *
     * @return User
     */
    public function getManager()
    {
        return $this->manager;
    }


    /**
     * @param User $collaborators
     */
    public function addCollaborator(User $collaborator)
    {
        if (!$this->collaborators->contains($collaborator)) {
            $this->collaborators->add($collaborator);
        }
    }


    /**
     * @return array
     */
    public function getCollaborators()
    {
        return $this->collaborators->toArray();
    }

    /**
     * @param User $collaborators
     */
    public function removeCollaborator(User $collaborator)
    {
        if (!$this->collaborators->contains($collaborator)) {
            return;
        }
        $this->collaborators->removeElement($collaborator);
    }

    /**
     * Remove all Collaborators for this tag
     */
    public function removeAllCollaborators()
    {
        $this->collaborators->clear();
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
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Person
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set brithdate
     *
     * @param \DateTime $brithdate
     *
     * @return Person
     */
    public function setBrithdate($brithdate)
    {
        $this->brithdate = $brithdate;

        return $this;
    }

    /**
     * Get brithdate
     *
     * @return \DateTime
     */
    public function getBrithdate()
    {
        return $this->brithdate;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Person
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the value of Id
     *
     * @param int id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of Avatar
     *
     * @param string avatar
     *
     * @return self
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }
    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }
}
