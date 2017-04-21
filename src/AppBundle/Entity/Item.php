<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="item")
 */
class Item{
	/**
     * @ORM\Column(type="string",length=25)
     * @ORM\Id
     */
	private $code;
	
	/**
     * @ORM\Column(type="string",length=64)
     */
	private $title;
	
	/**
     * @ORM\Column(type="string",length=32)
     */
	private $short_title;
	
	/**
     * @ORM\Column(type="string",length=25)
     */
	private $author;
	
	/**
     * @ORM\Column(type="string",length=25)
     */
	private $publisher;
	
	/**
     * @ORM\Column(type="date")
     */
	private $publication_year;
	
	/**
     * @ORM\Column(type="string",length=12)
     */
	private $language;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $isbn;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $total_unit;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $borrowed_unit;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $lost_unit;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $cost;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $disable;
	
	/**
     * @ORM\Column(type="integer")
	 * @ORM\ManyToOne(targetEntity="Type")
	 * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */	
	private $type;
	
	/**
     * @ORM\Column(type="integer")
	 * @ORM\ManyToOne(targetEntity="Category")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
	private $category_id;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $note;
}

?>