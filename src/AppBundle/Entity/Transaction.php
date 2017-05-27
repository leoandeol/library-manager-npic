<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionRepository")
 * @ORM\Table(name="transaction")
 */
class Transaction{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	/**
     * @var Member
	 *
	 * @ORM\ManyToOne(targetEntity="Member")
	 * @ORM\JoinColumn(name="member_code", referencedColumnName="code", onDelete="CASCADE")
     */
	private $member;
	/**
     * @var Item
	 *
	 * @ORM\ManyToOne(targetEntity="Item")
	 * @ORM\JoinColumn(name="item_code", referencedColumnName="code", onDelete="CASCADE")
     */
	private $item;
	/**
     * @ORM\Column(type="date",nullable=true)
     */
	private $borrow_date;
	/**
     * @ORM\Column(type="date",nullable=true)
     */
	private $return_date;
	/**
     * @ORM\Column(type="integer")
     */
	private $fine_cost_per_day;
	/**
     * @ORM\Column(type="string",length=8)
     */
	private $state;
	/**
     * @ORM\Column(type="string",length=64,nullable=true)
     */
	private $note;

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
     * Set member
     *
     * @param string $member
     *
     * @return Transaction
     */
    public function setMember($member)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return string
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set item
     *
     * @param string $item
     *
     * @return Transaction
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return string
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set borrowDate
     *
     * @param \DateTime $borrowDate
     *
     * @return Transaction
     */
    public function setBorrowDate($borrowDate)
    {
        $this->borrow_date = $borrowDate;

        return $this;
    }

    /**
     * Get borrowDate
     *
     * @return \DateTime
     */
    public function getBorrowDate()
    {
        return $this->borrow_date;
    }

    /**
     * Set returnDate
     *
     * @param \DateTime $returnDate
     *
     * @return Transaction
     */
    public function setReturnDate($returnDate)
    {
        $this->return_date = $returnDate;

        return $this;
    }

    /**
     * Get returnDate
     *
     * @return \DateTime
     */
    public function getReturnDate()
    {
        return $this->return_date;
    }

    /**
     * Set fineCostPerDay
     *
     * @param integer $fineCostPerDay
     *
     * @return Transaction
     */
    public function setFineCostPerDay($fineCostPerDay)
    {
        $this->fine_cost_per_day = $fineCostPerDay;

        return $this;
    }

    /**
     * Get fineCostPerDay
     *
     * @return integer
     */
    public function getFineCostPerDay()
    {
        return $this->fine_cost_per_day;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Transaction
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Transaction
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }
}
