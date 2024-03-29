<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comments")
 */
class Comments{
	
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
	 * @ORM\JoinColumn(name="member_code", referencedColumnName="code", nullable=true, onDelete="CASCADE")
     */
	private $member;
	
	/**
     * @var Librarian
	 *
	 * @ORM\ManyToOne(targetEntity="Librarian")
	 * @ORM\JoinColumn(name="librarian_username", referencedColumnName="username", nullable=true, onDelete="CASCADE")
     */
	private $librarian;
	
	/**
     * @var Item
	 *
	 * @ORM\ManyToOne(targetEntity="Item")
	 * @ORM\JoinColumn(name="item_code", referencedColumnName="code", onDelete="CASCADE")
     */
	private $item;
	
	/**
     * @ORM\Column(type="string",length=512)
     */
	private $comment;
	

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
     * @return Comments
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
     * Set librarian
     *
     * @param string $librarian
     *
     * @return Comments
     */
    public function setLibrarian($librarian)
    {
        $this->librarian = $librarian;

        return $this;
    }

    /**
     * Get librarian
     *
     * @return string
     */
    public function getLibrarian()
    {
        return $this->librarian;
    }

    /**
     * Set item
     *
     * @param string $item
     *
     * @return Comments
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Comments
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

}
