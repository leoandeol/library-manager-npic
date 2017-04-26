<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MemberRepository")
 * @ORM\Table(name="member")
 */
class Member{
	
	/**
     * @ORM\Column(type="string",length=25)
     * @ORM\Id
     */
	private $code;
	
	/**
     * @ORM\Column(type="string",length=25)
     */
	private $first_name;
	
	/**
     * @ORM\Column(type="string",length=25)
     */
	private $last_name;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $national_id;
	
	/**
     * @ORM\Column(type="string",length=25)
     */
	private $civil_situation;
	
	/**
     * @ORM\Column(type="string",length=1)
     */
	private $gender;
	
	/**
     * @ORM\Column(type="date")
     */
	private $dob;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $tel_mobile;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $tel_home;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $tel_ref;
	
	/**
     * @ORM\Column(type="string",length=25)
     */
	private $email;
	
	/**
     * @ORM\Column(type="date")
     */
	private $entry_date;
	
	/**
     * @ORM\Column(type="string",length=64)
     */
	private $password;
	
	/**
     * @var Staff
	 *
	 * @ORM\ManyToOne(targetEntity="Staff")
	 * @ORM\JoinColumn(name="staff_id", referencedColumnName="id", onDelete="CASCADE")
     */
	private $staff;
	
	/**
     * @var Student
	 *
	 * @ORM\OneToOne(targetEntity="Student")
	 * @ORM\JoinColumn(name="student_id", referencedColumnName="id", onDelete="CASCADE")
     */
	private $student;
	
	/**
     * @var Address
	 *
	 * @ORM\ManyToOne(targetEntity="Address")
	 * @ORM\JoinColumn(name="address_id", referencedColumnName="id", onDelete="CASCADE")
     */
	private $address;
	
	/**
     * @var Faculty
	 *
	 * @ORM\ManyToOne(targetEntity="Faculty")
	 * @ORM\JoinColumn(name="faculty_id", referencedColumnName="id", onDelete="CASCADE")
     */
	private $faculty;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $disable;
	
	/**
     * @ORM\Column(type="string",length=25,nullable=true)
     */
	private $disable_reason;
	
	/**
     * @ORM\Column(type="integer",nullable=true)
     */
	private $disable_year;
	
	public function __construct()
	{
		//nothing
	}

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Member
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Member
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Member
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set nationalId
     *
     * @param integer $nationalId
     *
     * @return Member
     */
    public function setNationalId($nationalId)
    {
        $this->national_id = $nationalId;

        return $this;
    }

    /**
     * Get nationalId
     *
     * @return integer
     */
    public function getNationalId()
    {
        return $this->national_id;
    }

    /**
     * Set civilSituation
     *
     * @param string $civilSituation
     *
     * @return Member
     */
    public function setCivilSituation($civilSituation)
    {
        $this->civil_situation = $civilSituation;

        return $this;
    }

    /**
     * Get civilSituation
     *
     * @return string
     */
    public function getCivilSituation()
    {
        return $this->civil_situation;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Member
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return Member
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set telMobile
     *
     * @param integer $telMobile
     *
     * @return Member
     */
    public function setTelMobile($telMobile)
    {
        $this->tel_mobile = $telMobile;

        return $this;
    }

    /**
     * Get telMobile
     *
     * @return integer
     */
    public function getTelMobile()
    {
        return $this->tel_mobile;
    }

    /**
     * Set telHome
     *
     * @param integer $telHome
     *
     * @return Member
     */
    public function setTelHome($telHome)
    {
        $this->tel_home = $telHome;

        return $this;
    }

    /**
     * Get telHome
     *
     * @return integer
     */
    public function getTelHome()
    {
        return $this->tel_home;
    }

    /**
     * Set telRef
     *
     * @param integer $telRef
     *
     * @return Member
     */
    public function setTelRef($telRef)
    {
        $this->tel_ref = $telRef;

        return $this;
    }

    /**
     * Get telRef
     *
     * @return integer
     */
    public function getTelRef()
    {
        return $this->tel_ref;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Member
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set entryDate
     *
     * @param \DateTime $entryDate
     *
     * @return Member
     */
    public function setEntryDate($entryDate)
    {
        $this->entry_date = $entryDate;

        return $this;
    }

    /**
     * Get entryDate
     *
     * @return \DateTime
     */
    public function getEntryDate()
    {
        return $this->entry_date;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Member
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set staff
     *
     * @param integer $staff
     *
     * @return Member
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;

        return $this;
    }

    /**
     * Get staff
     *
     * @return integer
     */
    public function getStaff()
    {
        return $this->staff;
    }

    /**
     * Set student
     *
     * @param integer $student
     *
     * @return Member
     */
    public function setStudent($student)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return integer
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set address
     *
     * @param integer $address
     *
     * @return Member
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return integer
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set faculty
     *
     * @param integer $faculty
     *
     * @return Member
     */
    public function setFaculty($faculty)
    {
        $this->faculty = $faculty;

        return $this;
    }

    /**
     * Get faculty
     *
     * @return integer
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Set disable
     *
     * @param integer $disable
     *
     * @return Member
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;

        return $this;
    }

    /**
     * Get disable
     *
     * @return integer
     */
    public function getDisable()
    {
        return $this->disable;
    }

    /**
     * Set disableReason
     *
     * @param string $disableReason
     *
     * @return Member
     */
    public function setDisableReason($disableReason)
    {
        $this->disable_reason = $disableReason;

        return $this;
    }

    /**
     * Get disableReason
     *
     * @return string
     */
    public function getDisableReason()
    {
        return $this->disable_reason;
    }

    /**
     * Set disableYear
     *
     * @param integer $disableYear
     *
     * @return Member
     */
    public function setDisableYear($disableYear)
    {
        $this->disable_year = $disableYear;

        return $this;
    }

    /**
     * Get disableYear
     *
     * @return integer
     */
    public function getDisableYear()
    {
        return $this->disable_year;
    }
}
