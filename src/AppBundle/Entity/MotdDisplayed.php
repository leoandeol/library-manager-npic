<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="motddisplayed")
 */
class MotdDisplayed{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	
	/**
     * @ORM\Column(type="string",length=640)
     */
	private $motd_content;

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
     * Set motd_content
     *
     * @param string $motd_content
     *
     * @return Logs
     */
    public function setMotdContent($motd_content)
    {
        $this->motd_content = $motd_content;

        return $this;
    }

    /**
     * Get motd_content
     *
     * @return string
     */
    public function getMotdContent()
    {
        return $this->motd_content;
    }
}
