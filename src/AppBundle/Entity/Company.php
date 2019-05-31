<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Company
 *
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRepository")
 * @ORM\Table(name="company")
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $industry;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $revenueBillion;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $marketCapitalBillion;

    /**
     * @ORM\Column(type="integer")
     */
    protected $employees;

    /**
     * @ORM\Column(type="text")
     */
    protected $headquarters;

    /**
     * @ORM\Column(type="text")
     */
    protected $contactEmail;

    /**
     * One Client has One Company.
     *
     * @var Client $client
     * @ORM\OneToOne(targetEntity="Client", mappedBy="company")
     */
    protected $client;

    /**
     * Get id
     *
     * @return integer
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
     * @return Company
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
     * Set industry
     *
     * @param string $industry
     *
     * @return Company
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;

        return $this;
    }

    /**
     * Get industry
     *
     * @return string
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * Set revenueBillion
     *
     * @param string $revenueBillion
     *
     * @return Company
     */
    public function setRevenueBillion($revenueBillion)
    {
        $this->revenueBillion = $revenueBillion;

        return $this;
    }

    /**
     * Get revenueBillion
     *
     * @return string
     */
    public function getRevenueBillion()
    {
        return $this->revenueBillion;
    }

    /**
     * Set marketCapitalBillion
     *
     * @param string $marketCapitalBillion
     *
     * @return Company
     */
    public function setMarketCapitalBillion($marketCapitalBillion)
    {
        $this->marketCapitalBillion = $marketCapitalBillion;

        return $this;
    }

    /**
     * Get marketCapitalBillion
     *
     * @return string
     */
    public function getMarketCapitalBillion()
    {
        return $this->marketCapitalBillion;
    }

    /**
     * Set employees
     *
     * @param integer $employees
     *
     * @return Company
     */
    public function setEmployees($employees)
    {
        $this->employees = $employees;

        return $this;
    }

    /**
     * Get employees
     *
     * @return integer
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    /**
     * Set headquarters
     *
     * @param string $headquarters
     *
     * @return Company
     */
    public function setHeadquarters($headquarters)
    {
        $this->headquarters = $headquarters;

        return $this;
    }

    /**
     * Get headquarters
     *
     * @return string
     */
    public function getHeadquarters()
    {
        return $this->headquarters;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     *
     * @return Company
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }


    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Company
     */
    public function addUser(User $user)
    {
        $this->client->addUser($user);

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(User $user)
    {
        $this->client->removeUser($user);
    }

    /**
     * Get users
     *
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->client->getUsers();
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Company
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
