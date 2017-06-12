<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FacultyRepository")
 * @ORM\Table(name="faculty")
 */
class Faculty{
	
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
    */
	private $id;
	
	/**
     * @ORM\Column(type="string",length=25)
    */
	
	private $name;

	public function __construct()
	{
		//nothing
	}
	
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
     * @return Faculty
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
}
