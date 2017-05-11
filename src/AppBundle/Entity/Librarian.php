<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LibrarianRepository")
 * @ORM\Table(name="librarian")
 */
class Librarian{	
	/**
     * @ORM\Column(type="string",length=25)
     * @ORM\Id
     */
	private $username;	
	/**
     * @ORM\Column(type="string",length=25)
     */
	private $first_name;	
	/**
     * @ORM\Column(type="string",length=25)
     */
	private $last_name;	
	/**
     * @ORM\Column(type="string",length=1)
     */
	private $gender;	
	/**
     * @ORM\Column(type="string",length=25)
     */
	private $email;	
	/**
     * @ORM\Column(type="string")
     */
	private $tel;	
	/**
     * @ORM\Column(type="date")
     */
	private $hire_date;	
	/**
     * @ORM\Column(type="date",nullable=true)
     */
	private $resign_date;	
	/**
     * @ORM\Column(type="string", length=64)
     */
	private $password;	
	/**
     * @ORM\Column(type="integer")
     */
	private $disable;
	/**
     * @var Address
	 *
	 * @ORM\ManyToOne(targetEntity="Address")
	 * @ORM\JoinColumn(name="address_id", referencedColumnName="id", onDelete="CASCADE")
     */
	private $address;

	public function __construct()
	{
		//nothing
	}
	
    /**
     * Set username
     *
     * @param string $username
     *
     * @return Librarian
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Librarian
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Librarian
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Librarian
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
     * Set email
     *
     * @param string $email
     *
     * @return Librarian
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
     * Set tel
     *
     * @param integer $tel
     *
     * @return Librarian
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return integer
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set hireDate
     *
     * @param \DateTime $hireDate
     *
     * @return Librarian
     */
    public function setHireDate($hireDate)
    {
		$this->hire_date = new \DateTime($hireDate);

        return $this;
    }

    /**
     * Get hireDate
     *
     * @return \DateTime
     */
    public function getHireDate()
    {
        return $this->hire_date;
    }

    /**
     * Set resignDate
     *
     * @param \DateTime $resignDate
     *
     * @return Librarian
     */
    public function setResignDate($resignDate)
    {
        $this->resign_date = $resignDate;

        return $this;
    }

    /**
     * Get resignDate
     *
     * @return \DateTime
     */
    public function getResignDate()
    {
        return $this->resign_date;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Librarian
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set disable
     *
     * @param integer $disable
     *
     * @return Librarian
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;

        return $this;
    }

    /**
     * Get disable
     *
     * @return integer
     */
    public function getDisable()
    {
        return $this->disable;
    }

    /**
     * Set address
     *
     * @param integer $address
     *
     * @return Librarian
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return integer
     */
    public function getAddress()
    {
        return $this->address;
    }
}
