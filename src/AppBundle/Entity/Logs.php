<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
	private $date;
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
     * Set loginDate
     *
     * @param \DateTime $loginDate
     *
     * @return Logs
     */
    public function setLoginDate($loginDate)
    {
        $this->login_date = $loginDate;

        return $this;
    }

    /**
     * Get loginDate
     *
     * @return \DateTime
     */
    public function getLoginDate()
    {
        return $this->login_date;
    }

    /**
     * Set logoutDate
     *
     * @param \DateTime $logoutDate
     *
     * @return Logs
     */
    public function setLogoutDate($logoutDate)
    {
        $this->logout_date = $logoutDate;

        return $this;
    }

    /**
     * Get logoutDate
     *
     * @return \DateTime
     */
    public function getLogoutDate()
    {
        return $this->logout_date;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Logs
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Logs
     */
    public function setLogDate($date)
    {
        $this->date = new \DateTime($date);

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getLogDate()
    {
        return $this->date;
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
