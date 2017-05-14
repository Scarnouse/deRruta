<?php

namespace DrutaBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="DrutaBundle\Entity\POIRepository")
 * @ORM\Table(name="poi")
 */
class POI
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Kiefernwald\DoctrineUuid\Doctrine\ORM\UuidGenerator")
     * @JMS\Groups({"routes", "pois", "routes_by_user"})
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string")
     * @JMS\Groups({"routes", "pois", "routes_by_user"})
     */
    protected $name;

    /**
     * @ORM\Column(name="latitude", type="string", length=255)
     * @JMS\Groups({"pois"})
     */
    protected $latitude;

    /**
     * @ORM\Column(name="longitude", type="string", length=255)
     * @JMS\Groups({"pois"})
     */
    protected $longitude;

    /**
     * @ORM\Column(name="description", type="string")
     * @JMS\Groups({"pois"})
     */
    protected $description;

    /**
     * @ORM\Column(name="file_name_icon", type="string", length=50, nullable=true)
     */
    protected $filenameIcon;

    /**
     * @Assert\File(maxSize="5242880")
     */
    protected $fileIcon;

    /**
     * @ORM\Column(name="file_name_image", type="string", length=50, nullable=true)
     */
    protected $filenameImage;

    /**
     * @Assert\File(maxSize="5242880")
     */
    protected $fileImage;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     * @JMS\Groups({"pois"})
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="DrutaBundle\Entity\Route", inversedBy="POI")
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $route;

    function __construct()
    {
        $this->filenameImage = "without_image.png";
        $this->filenameIcon = "place-map-marker-default.png";
        $this->date = new \DateTime();
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
    public function getName()
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
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
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
    public function getFilenameIcon()
    {
        return $this->filenameIcon;
    }

    /**
     * @param mixed $filenameIcon
     */
    public function setFilenameIcon($filenameIcon)
    {
        $this->filenameIcon = $filenameIcon;
    }

    /**
     * @return mixed
     */
    public function getFileIcon()
    {
        return $this->fileIcon;
    }

    /**
     * @param mixed $fileIcon
     */
    public function setFileIcon($fileIcon)
    {
        $this->fileIcon = $fileIcon;
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
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
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

    public function getAbsolutePathIcon()
    {
        return null === $this->getFileIcon()
            ? null
            : $this->getUploadRootDir().'/'.$this->getFilenameIcon();
    }

    public function getWebPathIcon()
    {
        return null === $this->getFilenameIcon()
            ? null
            : "/".$this->getUploadDir().'/'.$this->getFilenameIcon();
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