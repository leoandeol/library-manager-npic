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
	 * @ORM\ManyToOne(targetEntity="member")
	 * @ORM\JoinColumn(name="member_code", referencedColumnName="code", onDelete="CASCADE")
     */
	private $member;
	/**
     * @ORM\Column(type="date")
     */
	private $log_date;
	/**
     * @ORM\Column(type="string",length=64)
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
     * Set logDate
     *
     * @param \DateTime $logDate
     *
     * @return UserLogs
     */
    public function setLogDate($logDate)
    {
        $this->log_date = new \DateTime($logDate);

        return $this;
    }

    /**
     * Get logDate
     *
     * @return \DateTime
     */
    public function getLogDate()
    {
        return $this->log_date;
    }

    /**
     * Set action
     *
     * @param string $action
     *
     * @return UserLogs
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

    /**
     * Set member
     *
     * @param \AppBundle\Entity\member $member
     *
     * @return UserLogs
     */
    public function setMember(\AppBundle\Entity\member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \AppBundle\Entity\member
     */
    public function getMember()
    {
        return $this->member;
    }
}
