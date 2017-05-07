<?php

namespace DrutaBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @ORM\Entity
 * @ORM\Table(name="route")
 */
class Route
{

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Kiefernwald\DoctrineUuid\Doctrine\ORM\UuidGenerator")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="description", type="string")
     */
    protected $description;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @var string
     * @ORM\Column(name="file_name_image", type="string", length=50, nullable=true)
     */
    protected $filenameImage;

    /**
     * @Assert\File(maxSize="5242880")
     */
    protected $fileImage;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="DrutaBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var POI
     * @var ArrayCollection<POI>
     * @ORM\OneToMany(targetEntity="DrutaBundle\Entity\POI", mappedBy="route")
     */
    protected $POI;

    function __construct()
    {
        $this->filenameImage = "without_image.png";
        $this->date = new \DateTime();
        $this->POI = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName ()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getFilenameImage()
    {
        return $this->filenameImage;
    }

    /**
     * @param mixed $filenameImage
     */
    public function setFilenameImage($filenameImage)
    {
        $this->filenameImage = $filenameImage;
    }

    /**
     * @return mixed
     */
    public function getFileImage()
    {
        return $this->fileImage;
    }

    /**
     * @param mixed $fileImage
     */
    public function setFileImage($fileImage)
    {
        $this->fileImage = $fileImage;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return ArrayCollection
     */
    public function getPOI()
    {
        return $this->POI;
    }

    /**
     * @param ArrayCollection $POI
     */
    public function setPOI($POI)
    {
        $this->POI = $POI;
    }

    public function getAbsolutePathImage()
    {
        return null === $this->getFileImage()
            ? null
            : $this->getUploadRootDir().'/'.$this->getFilenameImage();
    }

    public function getWebPathImage()
    {
        return null === $this->getFilenameImage()
            ? null
            : "/".$this->getUploadDir().'/'.$this->getFilenameImage();
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' .$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads';
    }

    function __toString()
    {
        return $this->getName();
    }
}