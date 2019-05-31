<?php


namespace AppBundle\Entity;

use AppBundle\Model\BaseInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Class Client
 *
 * Every  Client relates to a Company.
 * Every Client can have only 1 Company assigned, and every Company must belong to just 1 Client.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientRepository")
 * @ORM\Table(name="client")
 *
 * @UniqueEntity(fields="email", message="Sorry, this email address is already in use.")
 * @UniqueEntity(fields="company", message="Sorry, this company is already taken.")
 *
 */
class Client implements BaseInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique = true)
     * @var string
     *
     * @Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     * @var integer
     */
    protected $phone;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="clients")
     */
    protected $users;

    /**
     * One Client has One Company.
     *
     * @ORM\OneToOne(targetEntity="Company", inversedBy="client")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     *
     */
    protected $company;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     *
     * @return Client
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Client
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Client
     */
    public function addUser(User $user)
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addClient($this);
        }

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Client
     */
    public function removeUser(User $user)
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeClient($this);
        }

        return $this;
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     *
     * @return Client
     */
    public function setCompany(Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \AppBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }
}
