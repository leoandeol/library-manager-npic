<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
}


?>