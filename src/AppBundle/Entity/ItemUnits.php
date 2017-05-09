<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemUnitsRepository")
 * @ORM\Table(name="itemunits")
 */
class ItemUnits {
	
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	
	/**
     * @var item
	 *
	 * @ORM\ManyToOne(targetEntity="Item")
	 * @ORM\JoinColumn(name="item_code",nullable=false, referencedColumnName="code", onDelete="CASCADE")
     */
	 private $item;
	 
	 /**
	 * @ORM\Column(type="integer")
	 */
	 private $amount;
	 
	 /**
	 * @ORM\Column(type="date")
	 */
	 private $add_date;
	 
	 public function __construct(){
		 //nothing
	 }
}
?>