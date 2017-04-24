<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="staff")
 */
class Staff{
	
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	
	/**
     * @ORM\Column(type="string",length=32)
     */
	 private $function;
	 
	 /**
     * @ORM\Column(type="string",length=32)
     */
	 private $department;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

	public function __construct()
	{
		//nothing
	}
	
    /**
     * Set function
     *
     * @param string $function
     *
     * @return Staff
     */
    public function setFunction($function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Set department
     *
     * @param string $department
     *
     * @return Staff
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }
}
