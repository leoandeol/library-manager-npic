<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="userlogs")
 */
class UserLogs{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	/**
     * @var Member
	 *
	 * @ORM\OneToOne(targetEntity="member")
	 * @ORM\JoinColumn(name="member_code", referencedColumnName="code", onDelete="CASCADE")
     */
	private $member;
	/**
     * @ORM\Column(type="date")
     */
	private $login_date;
	/**
     * @ORM\Column(type="date")
     */
	private $logout_date;
	/**
     * @ORM\Column(type="string",length=64)
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
}
