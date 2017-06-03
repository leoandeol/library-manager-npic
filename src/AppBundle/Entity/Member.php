<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
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
     * @ORM\Column(type="string")
     */
	private $tel_mobile;
	
	/**
     * @ORM\Column(type="string")
     */
	private $tel_home;
	
	/**
     * @ORM\Column(type="string")
     */
	private $tel_ref;
	
	/**
     * @ORM\Column(type="string",length=255)
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
     * @ORM\Column(type="boolean")
     */
	private $staff;
	
	/**
     * @var function
	 *
	 * @ORM\ManyToOne(targetEntity="StaffFunction")
	 * @ORM\JoinColumn(name="function_id",nullable=true, referencedColumnName="id", onDelete="CASCADE")
     */
	private $function;
	
	/**
     * @ORM\Column(type="boolean")
     */
	private $student;
	
	/**
     * @var major
	 *
	 * @ORM\ManyToOne(targetEntity="Major")
	 * @ORM\JoinColumn(name="major_id",nullable=true, referencedColumnName="id", onDelete="CASCADE")
     */
	private $major;
	
	/**
     * @var degree
	 *
	 * @ORM\ManyToOne(targetEntity="Degree")
	 * @ORM\JoinColumn(name="degree_id",nullable=true, referencedColumnName="id", onDelete="CASCADE")
     */
	private $degree;
	
	/**
     * @var degree_year
	 *
	 * @ORM\ManyToOne(targetEntity="DegreeYear")
	 * @ORM\JoinColumn(name="degree_year_id",nullable=true, referencedColumnName="id", onDelete="CASCADE")
     */
	private $degree_year;
	
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
     * @ORM\Column(type="date",nullable=true)
     */
	private $disable_date;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $current_borrowed_books_nb;
	
	/**
	 *
	 * @ORM\Column{type="string")
	 * 
	 * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 1000,
     *     minHeight = 200,
     *     maxHeight = 1000
     * )
     */
	private $avatar_path;
	
	
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
        $this->entry_date = new \DateTime($entryDate);

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
     * Set disableDate
     *
     * @param integer $disableDate
     *
     * @return Member
     */
    public function setDisableDate($disableDate)
    {
        $this->disable_date = new \DateTime($disableDate);

        return $this;
    }

    /**
     * Get disableDate
     *
     * @return integer
     */
    public function getDisableDate()
    {
        return $this->disable_date;
    }

    /**
     * Set function
     *
     * @param \AppBundle\Entity\StaffFunction $function
     *
     * @return Member
     */
    public function setFunction(\AppBundle\Entity\StaffFunction $function = null)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return \AppBundle\Entity\StaffFunction
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Set major
     *
     * @param \AppBundle\Entity\Major $major
     *
     * @return Member
     */
    public function setMajor(\AppBundle\Entity\Major $major = null)
    {
        $this->major = $major;

        return $this;
    }

    /**
     * Get major
     *
     * @return \AppBundle\Entity\Major
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * Set degree
     *
     * @param \AppBundle\Entity\Degree $degree
     *
     * @return Member
     */
    public function setDegree(\AppBundle\Entity\Degree $degree = null)
    {
        $this->degree = $degree;

        return $this;
    }

    /**
     * Get degree
     *
     * @return \AppBundle\Entity\Degree
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set degreeYear
     *
     * @param \AppBundle\Entity\DegreeYear $degreeYear
     *
     * @return Member
     */
    public function setDegreeYear(\AppBundle\Entity\DegreeYear $degreeYear = null)
    {
        $this->degree_year = $degreeYear;

        return $this;
    }

    /**
     * Get degreeYear
     *
     * @return \AppBundle\Entity\DegreeYear
     */
    public function getDegreeYear()
    {
        return $this->degree_year;
    }

    /**
     * Set currentBorrowedBooksNb
     *
     * @param integer $currentBorrowedBooksNb
     *
     * @return Member
     */
    public function setCurrentBorrowedBooksNb($currentBorrowedBooksNb)
    {
        $this->current_borrowed_books_nb = $currentBorrowedBooksNb;

        return $this;
    }

    /**
     * Get currentBorrowedBooksNb
     *
     * @return integer
     */
    public function getCurrentBorrowedBooksNb()
    {
        return $this->current_borrowed_books_nb;
    }

    /**
     * Set avatarPath
     *
     * @param string $avatarPath
     *
     * @return Member
     */
    public function setAvatarPath($avatarPath)
    {
        $this->avatar_path = $avatarPath;

        return $this;
    }

    /**
     * Get avatarPath
     *
     * @return string
     */
    public function getAvatarPath()
    {
        return $this->avatar_path;
    }
}
