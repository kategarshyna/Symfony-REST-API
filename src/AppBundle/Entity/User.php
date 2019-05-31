<?php

namespace AppBundle\Entity;

use AppBundle\Model\BaseInterface;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Email;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @Serializer\ExclusionPolicy("all")
 *
 * @UniqueEntity(fields="email", message="Sorry, this email address is already in use.")
 * @UniqueEntity(fields="username", message="Sorry, this username is already taken.")
 *
 */
class User extends BaseUser implements BaseInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose()
     * @Serializer\Groups({"Users"})
     */
    protected $id;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"Users"})
     *
     * @Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    protected $email;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"Users"})
     */
    protected $username;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Expose()
     * @Serializer\Groups({"Users"})
     */
    protected $firstName;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Expose()
     * @Serializer\Groups({"Users"})
     */
    protected $lastName;

    /**
     * @var Client $clients
     * @ORM\ManyToMany(targetEntity="Client", inversedBy="users")
     */
    protected $clients;

    public function __construct()
    {
        parent::__construct();
        $this->clients = new ArrayCollection();
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
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
     * @return User
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
     * Add client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return User
     */
    public function addClient(Client $client)
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->addUser($this);
        }

        return $this;
    }

    /**
     * Remove client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return User
     */
    public function removeClient(Client $client)
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            $client->removeUser($this);
        }

        return $this;
    }

    /**
     * Get clients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClients()
    {
        return $this->clients;
    }
}
