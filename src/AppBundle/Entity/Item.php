<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 * @ORM\Table(name="item")
 */
class Item{
	/**
     * @ORM\Column(type="string",length=25)
     * @ORM\Id
     */
	private $code;
	
	/**
     * @ORM\Column(type="string",length=64)
     */
	private $title;
	
	/**
     * @ORM\Column(type="string",length=25)
     */
	private $author;
	
	/**
     * @ORM\Column(type="string",length=25)
     */
	private $publisher;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $publication_year;
	
	/**
     * @var language
	 *
	 * @ORM\ManyToOne(targetEntity="Languages")
	 * JoinColumn(name="language_id", referencedColumnName="id", onDelete="CASCADE")
     */
	private $language;
	
	/**
     * @ORM\Column(type="integer",nullable=true)
     */
	private $isbn;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $total_unit;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $borrowed_unit;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $booked_unit;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $lost_unit;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $cost;
	
	/**
     * @ORM\Column(type="integer")
     */
	private $disable;
	
	/**
     * @var Type
	 *
	 * @ORM\ManyToOne(targetEntity="Type")
	 * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="CASCADE")
     */
	private $type;
	
	/**
     * @var Category
	 *
	 * @ORM\ManyToOne(targetEntity="Category")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     */
	private $category;
	
	/**
     * @ORM\Column(type="integer",nullable=true)
     */
	private $note;
	
	/**
     * @ORM\Column(type="string",length=13)
     */
	private $bookable;

	/**
     * @ORM\Column(type="date")
     */
	private $add_date;
		
		
	/*
	public function __construct($code,$title,$short_title,$author,$publisher,$publication_year,
	$language,$isbn = NULL,$total_unit = 0,$borrowed_unit = 0,$cost,$disable,$type,$category,
	$note = '',$bookable,$add_date)
	{
		$this->$code = $code;
		$this->$title = $title;
		$this->$short_title = $short_title;
		$this->$author = $author;
		$this->$publisher = $publisher;
		$this->$publication_year = $publication_year;
		$this->$language = $language;
		$this->$isbn = $isbn;
		$this->$total_unit = $total_unit;
		$this->$borrowed_unit = $borrowed_unit;
		$this->$cost = $cost;
		$this->$disable = $disable;
		$this->$type = $type;
		$this->$category = $category;
		$this->$note = $note;
		$this->$bookable = $bookable;
		$this->$add_date = $add_date;
	}
	*/
	
	public function __construct(){
		
	}
	
    /**
     * Set code
     *
     * @param string $code
     *
     * @return Item
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
     * Set title
     *
     * @param string $title
     *
     * @return Item
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set shortTitle
     *
     * @param string $shortTitle
     *
     * @return Item
     */
    public function setShortTitle($shortTitle)
    {
        $this->short_title = $shortTitle;

        return $this;
    }

    /**
     * Get shortTitle
     *
     * @return string
     */
    public function getShortTitle()
    {
        return $this->short_title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Item
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set publisher
     *
     * @param string $publisher
     *
     * @return Item
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set publicationYear
     *
     * @param \DateTime $publicationYear
     *
     * @return Item
     */
    public function setPublicationYear($publicationYear)
    {
        $this->publication_year = $publicationYear;

        return $this;
    }

    /**
     * Get publicationYear
     *
     * @return \DateTime
     */
    public function getPublicationYear()
    {
        return $this->publication_year;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Item
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set isbn
     *
     * @param integer $isbn
     *
     * @return Item
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return integer
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set totalUnit
     *
     * @param integer $totalUnit
     *
     * @return Item
     */
    public function setTotalUnit($totalUnit)
    {
        $this->total_unit = $totalUnit;

        return $this;
    }

    /**
     * Get totalUnit
     *
     * @return integer
     */
    public function getTotalUnit()
    {
        return $this->total_unit;
    }

	/**
     * Set bookedUnit
     *
     * @param integer $bookedUnit
     *
     * @return Item
     */
    public function setBookedUnit($bookedUnit)
    {
        $this->booked_unit = $bookedUnit;

        return $this;
    }

    /**
     * Get bookedUnit
     *
     * @return integer
     */
    public function getBookedUnit()
    {
        return $this->booked_unit;
    }
	
    /**
     * Set borrowedUnit
     *
     * @param integer $borrowedUnit
     *
     * @return Item
     */
    public function setBorrowedUnit($borrowedUnit)
    {
        $this->borrowed_unit = $borrowedUnit;

        return $this;
    }

    /**
     * Get borrowedUnit
     *
     * @return integer
     */
    public function getBorrowedUnit()
    {
        return $this->borrowed_unit;
    }

    /**
     * Set lostUnit
     *
     * @param integer $lostUnit
     *
     * @return Item
     */
    public function setLostUnit($lostUnit)
    {
        $this->lost_unit = $lostUnit;

        return $this;
    }

    /**
     * Get lostUnit
     *
     * @return integer
     */
    public function getLostUnit()
    {
        return $this->lost_unit;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     *
     * @return Item
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return integer
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set disable
     *
     * @param integer $disable
     *
     * @return Item
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
     * Set type
     *
     * @param integer $type
     *
     * @return Item
     */
    public function setTyppe($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getTyppe()
    {
        return $this->type;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Item
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return Item
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set category
     *
     * @param integer $category
     *
     * @return Item
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return integer
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set bookable
     *
     * @param string $bookable
     *
     * @return Item
     */
    public function setBookable($bookable)
    {
        $this->bookable = $bookable;

        return $this;
    }

    /**
     * Get bookable
     *
     * @return string
     */
    public function getBookable()
    {
        return $this->bookable;
    }

    /**
     * Set addDate
     *
     * @param \DateTime $addDate
     *
     * @return Item
     */
    public function setAddDate($addDate)
    {
        $this->add_date = new \DateTime($addDate);

        return $this;
    }

    /**
     * Get addDate
     *
     * @return \DateTime
     */
    public function getAddDate()
    {
        return $this->add_date;
    }
	
	/**
	 * isInStock
	 * 
	 * @return boolean
	 */
	function isInStock(){
		return $this->getTotalUnit() > $this->getBorrowedUnit()+$this->getLostUnit();
	}
}
