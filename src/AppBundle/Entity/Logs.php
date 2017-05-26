<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LogsRepository")
 * @ORM\Table(name="logs")
 */
class Logs{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	/**
     * @var Librarian
	 *
	 * @ORM\ManyToOne(targetEntity="Librarian")
	 * @ORM\JoinColumn(name="librarian_username", referencedColumnName="username", onDelete="CASCADE")
     */
	private $lib;
	/**
     * @ORM\Column(type="date")
     */
	private $logDate;
	/**
     * @ORM\Column(type="string",length=512)
     */
	private $action;

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
     * Set lib
     *
     * @param string $lib
     *
     * @return Logs
     */
    public function setLib($lib)
    {
        $this->lib = $lib;

        return $this;
    }

    /**
     * Get lib
     *
     * @return string
     */
    public function getLib()
    {
        return $this->lib;
    }


    /**
     * Set logDate
     *
     * @param \DateTime $date
     *
     * @return Logs
     */
    public function setLogDate($date)
    {
        $this->logDate = new \DateTime($date);

        return $this;
    }

    /**
     * Get logDate
     *
     * @return \DateTime
     */
    public function getLogDate()
    {
        return $this->logDate;
    }

    /**
     * Set action
     *
     * @param string $action
     *
     * @return Logs
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}
