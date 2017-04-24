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
     * @ORM\Column(type="string",length=25)
	 * @ORM\OneToOne(targetEntity="Member")
     */
	private $member;
	
	/**
     * @ORM\Column(type="string",length=25)
	 * @ORM\OneToOne(targetEntity="Item")
     */
	private $item;
	
	/**
     * @ORM\Column(type="string",length=512)
     */
	private $comment;
	
	/**
     * @ORM\Column(type="integer",nullable=true)
	 * @ORM\OneToOne(targetEntity="Comments")
     */
	private $response;

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

    /**
     * Set response
     *
     * @param integer $response
     *
     * @return Comments
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get response
     *
     * @return integer
     */
    public function getResponse()
    {
        return $this->response;
    }
}
