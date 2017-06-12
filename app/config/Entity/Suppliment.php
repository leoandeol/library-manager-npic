<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="suppliments")
 */
class Suppliment{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	/**
     * @ORM\Column(type="string",length=32)
     */
	private $name;
	/**
     * @ORM\Column(type="integer")
     */
	private $amount;
	/**
     * @ORM\Column(type="integer")
     */
	private $disable;
	/**
     * @var Item
	 *
	 * @ORM\OneToOne(targetEntity="Item")
	 * @ORM\JoinColumn(name="item_code", referencedColumnName="code", onDelete="CASCADE")
     */
	private $item;	

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
     * @return Suppliment
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

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Suppliment
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
     * Set disable
     *
     * @param integer $disable
     *
     * @return Suppliment
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;

        return $this;
    }

    /**
     * Get disable
     *
     * @return integer
     */
    public function getDisable()
    {
        return $this->disable;
    }

    /**
     * Set itemCode
     *
     * @param string $itemCode
     *
     * @return Suppliment
     */
    public function setItemCode($itemCode)
    {
        $this->item_code = $itemCode;

        return $this;
    }

    /**
     * Get itemCode
     *
     * @return string
     */
    public function getItemCode()
    {
        return $this->item_code;
    }
}
