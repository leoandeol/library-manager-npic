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
     * @var lib_for_borrow
	 *
	 * @ORM\ManyToOne(targetEntity="Librarian")
	 * @ORM\JoinColumn(name="lib_for_borrow",nullable=true, referencedColumnName="username", onDelete="CASCADE")
     */
	private $lib_for_borrow;
	/**
     * @var lib_for_return
	 *
	 * @ORM\ManyToOne(targetEntity="Librarian")
	 * @ORM\JoinColumn(name="lib_for_return",nullable=true, referencedColumnName="username", onDelete="CASCADE")
     */
	private $lib_for_return;
	/**
     * @ORM\Column(type="date",nullable=true)
     */
	private $booked_date;
	/**
	/**
     * @ORM\Column(type="date",nullable=true)
     */
	private $borrow_date;
	/**
     * @ORM\Column(type="date",nullable=true)
     */
	private $return_date;
	/**
     * @ORM\Column(type="date",nullable=true)
     */
	private $to_return_date;
	/**
     * @ORM\Column(type="integer")
     */
	private $fine_cost_per_day;
	/**
     * @ORM\Column(type="integer")
     */
	private $fine_to_pay;
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
     * Set fineToPay
     *
     * @param integer $fineToPay
     *
     * @return Transaction
     */
    public function setFineToPay($fineToPay)
    {
        $this->fine_to_pay = $fineToPay;

        return $this;
    }

    /**
     * Get fineToPay
     *
     * @return integer
     */
    public function getFineToPay()
    {
        return $this->fine_to_pay;
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

    /**
     * Set libForBorrow
     *
     * @param \AppBundle\Entity\Librarian $libForBorrow
     *
     * @return Transaction
     */
    public function setLibForBorrow(\AppBundle\Entity\Librarian $libForBorrow = null)
    {
        $this->lib_for_borrow = $libForBorrow;

        return $this;
    }

    /**
     * Get libForBorrow
     *
     * @return \AppBundle\Entity\Librarian
     */
    public function getLibForBorrow()
    {
        return $this->lib_for_borrow;
    }

    /**
     * Set libForReturn
     *
     * @param \AppBundle\Entity\Librarian $libForReturn
     *
     * @return Transaction
     */
    public function setLibForReturn(\AppBundle\Entity\Librarian $libForReturn = null)
    {
        $this->lib_for_return = $libForReturn;

        return $this;
    }

    /**
     * Get libForReturn
     *
     * @return \AppBundle\Entity\Librarian
     */
    public function getLibForReturn()
    {
        return $this->lib_for_return;
    }

    /**
     * Set toReturnDate
     *
     * @param \DateTime $toReturnDate
     *
     * @return Transaction
     */
    public function setToReturnDate($toReturnDate)
    {
        $this->to_return_date = new \DateTime($toReturnDate);

        return $this;
    }

    /**
     * Get toReturnDate
     *
     * @return \DateTime
     */
    public function getToReturnDate()
    {
        return $this->to_return_date;
    }

    /**
     * Set bookedDate
     *
     * @param \DateTime $bookedDate
     *
     * @return Transaction
     */
    public function setBookedDate($bookedDate)
    {
        $this->booked_date = new \DateTime($bookedDate);

        return $this;
    }

    /**
     * Get bookedDate
     *
     * @return \DateTime
     */
    public function getBookedDate()
    {
        return $this->booked_date;
    }
}
