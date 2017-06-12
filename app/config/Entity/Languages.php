<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LanguagesRepository")
 * @ORM\Table(name="languages")
 */
class Languages{
	
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	 private $lang_name;

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
     * Set langName
     *
     * @param string $langName
     *
     * @return Languages
     */
    public function setLangName($langName)
    {
        $this->lang_name = $langName;

        return $this;
    }

    /**
     * Get langName
     *
     * @return string
     */
    public function getLangName()
    {
        return $this->lang_name;
    }
}
