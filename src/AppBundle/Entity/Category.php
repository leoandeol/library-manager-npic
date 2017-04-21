<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category{
	
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;

	/**
     * @ORM\Column(type="string",length=32)
     */
	private $subject;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $disable;
	
	
}

?>