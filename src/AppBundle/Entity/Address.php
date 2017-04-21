<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="address")
 */
class Address {
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	
	/**
     * @ORM\Column(type="string",length=32)
     */
	private $city;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $postal_code;
	
	/**
     * @ORM\Column(type="string",length=128)
     */
	private $street;
}

?>