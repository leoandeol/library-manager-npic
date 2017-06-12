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
     * Set amount
     *
     * @param integer $amount
     *
     * @return ItemUnits
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set addDate
     *
     * @param \DateTime $addDate
     *
     * @return ItemUnits
     */
    public function setAddDate($addDate)
    {
        $this->add_date = $addDate;

        return $this;
    }

    /**
     * Get addDate
     *
     * @return \DateTime
     */
    public function getAddDate()
    {
        return $this->add_date;
    }

    /**
     * Set item
     *
     * @param \AppBundle\Entity\Item $item
     *
     * @return ItemUnits
     */
    public function setItem(\AppBundle\Entity\Item $item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \AppBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }
}
