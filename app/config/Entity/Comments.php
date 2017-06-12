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
	 * @ORM\OneToOne(targetEntity="Member")
	 * @ORM\JoinColumn(name="member_code", referencedColumnName="code", onDelete="CASCADE")
     */
	private $member;
	
	/**
     * @var Item
	 *
	 * @ORM\OneToOne(targetEntity="Item")
	 * @ORM\JoinColumn(name="item_code", referencedColumnName="code", onDelete="CASCADE")
     */
	private $item;
	
	/**
     * @ORM\Column(type="string",length=512)
     */
	private $comment;
	
	/**
     * @var Response
	 *
	 * @ORM\OneToOne(targetEntity="Comments")
	 * @ORM\JoinColumn(name="response_id", referencedColumnName="id", onDelete="CASCADE")
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
