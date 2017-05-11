<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="degree_year")
 */
class DegreeYear{
	
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
    */
	private $id;
	
	/**
     * @ORM\Column(type="integer")
    */
	
	private $year;
	

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
     * Set year
     *
     * @param integer $year
     *
     * @return DegreeYear
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }
}
