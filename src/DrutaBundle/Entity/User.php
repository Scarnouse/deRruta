<?php

namespace DrutaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DrutaBundle\Entity\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="DrutaBundle\Entity\UserRepository")
 * @UniqueEntity(
 *     fields={"username"},
 *     message="Email en uso"
 * )
 * @ORM\Table(name="user")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Kiefernwald\DoctrineUuid\Doctrine\ORM\UuidGenerator")
     * @JMS\Groups({"user", "routes"})
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", type="string")
     * @JMS\Groups({"user"})
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string")
     */
    protected $lastName;

    /**
     * @ORM\Column(name="file_name_image", type="string", length=50, nullable=true)
     * @JMS\Groups({"user"})
     */
    protected $filenameImage;

    /**
     * @Assert\File(maxSize="5242880")
     */
    protected $fileImage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $salt;

    /**
     * @var ArrayCollection<Route>
     * @ORM\OneToMany(targetEntity="DrutaBundle\Entity\Route", mappedBy="user")
     * @JMS\Groups({"user"})
     */
    //protected $route;

    /**
     * @var Role
     * @ORM\OneToOne(targetEntity="DrutaBundle\Entity\Role", mappedBy="user")
     *
     */
    protected $roles;

    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message = "El email introducido no es válido",
     *     checkMX = true
     * )
     * @JMS\Groups({"user", "routes"})
     */
    protected $email;

    /**
     * @ORM\Column(name="username", type="string", length=255)
     *
     */
    protected $username;

    /**
     * @ORM\Column(name="date_member", type="date")
     * @JMS\Groups({"user"})
     */
    protected $dateMember;

    function __construct()
    {
        $this->filenameImage = "without_avatar.png";
        $this->dateMember = new \DateTime();
        //$this->route = new ArrayCollection();
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return ArrayCollection
     */
/*    public function getRoute()
    {
        return $this->route;
    }*/

    /**
     * @param ArrayCollection $route
     */
/*    public function setRoute($route)
    {
        $this->route = $route;
    }*/

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getDateMember()
    {
        return $this->dateMember;
    }

    /**
     * @param mixed $dateMember
     */
    public function setDateMember($dateMember)
    {
        $this->dateMember = $dateMember;
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

    public function getRoles()
    {
        return array(
            $this->roles->getName()

        );
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            $this->salt
            ) = unserialize($serialized);
    }
}