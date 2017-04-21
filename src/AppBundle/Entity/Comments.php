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
	 * OneToOne(targetEntity="Member")
	 * JoinColumn(name="member_code", referencedColumnName="code")
     */
	private $member;
	
	/**
     * @ORM\Column(type="string",length=25)
	 * OneToOne(targetEntity="Item")
	 * JoinColumn(name="item_code", referencedColumnName="code")
     */
	private $item;
	
	/**
     * @ORM\Column(type="string",length=512)
     */
	private $comment;
	
	/**
     * @ORM\Column(type="integer",nullable=true)
	 * OneToOne(targetEntity="Comments")
	 * JoinColumn(name="response_id", referencedColumnName="id")
     */
	private $response;
}


?>