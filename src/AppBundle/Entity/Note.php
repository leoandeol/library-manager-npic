<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="note")
 */
class Note{
	/**
     * @ORM\Column(type="string",length=25)
     * @ORM\Id
	 * @ORM\OneToOne(targetEntity="Item")
     */
	private $item;
	/**
     * @ORM\Column(type="string",length=25)
     * @ORM\Id
	 * @ORM\OneToOne(targetEntity="Member")
     */
	private $member;
	/**
     * @ORM\Column(type="integer")
     */
	private $note;

	public function __construct()
	{
		//nothing
	}
	
    /**
     * Set item
     *
     * @param string $item
     *
     * @return Note
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
     * Set member
     *
     * @param string $member
     *
     * @return Note
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
     * Set note
     *
     * @param integer $note
     *
     * @return Note
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }
}
