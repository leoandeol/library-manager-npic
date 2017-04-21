<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="librarian")
 */
class Librarian{
	
	/**
     * @ORM\Column(type="varchar",length=25)
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
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="integer")
	 * @ORM ManyToOne(targetEntity="Address")
	 * @ORM JoinColumn(name="address_id", referencedColumnName="id")
     */
	private $address;
}

?>