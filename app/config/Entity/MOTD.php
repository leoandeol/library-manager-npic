<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="motd")
 */
class MOTD{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	
	/**
     * @ORM\Column(type="string",length=640)
     */
	private $text;

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
     * Set text
     *
     * @param string $text
     *
     * @return Logs
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
