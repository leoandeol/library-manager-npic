<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
     * @ORM\Column(type="integer",nullable=true)
	 * @ORM\OneToOne(targetEntity="Staff")
	 * @ORM\JoinColumn(name="staff_id", referencedColumnName="id")
     */
	private $staff;
	
	/**
     * @ORM\Column(type="integer",nullable=true)
	 * @ORM\OneToOne(targetEntity="Student")
	 * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
	private $student;
	
	/**
     * @ORM\Column(type="integer")
	 * @ORM\ManyToOne(targetEntity="Address")
	 * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     */
	private $address;
	
	/**
     * @ORM\Column(type="integer")
	 * @ORM\ManyToOne(targetEntity="Faculty")
	 * @ORM\JoinColumn(name="faculty_id", referencedColumnName="id")
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
	
	
}

?>