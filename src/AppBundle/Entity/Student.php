<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="student")
 */
class Student{
	
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	
	/**
     * @ORM\Column(type="string",length=32)
     */
	private $major;
	
	/**
     * @ORM\Column(type="string",length=32)
     */
	private $degree;
	
	/**
     * @ORM\Column(type="string",length=32)
     */
	private $year;
	
}

?>