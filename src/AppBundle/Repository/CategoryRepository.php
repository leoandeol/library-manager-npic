<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository{

	public function findAllCategories(){
		return $this->getEntityManager()->createQuery(
			'Select c.id, c.subject from AppBundle:Category c where c.disable=0'
		)->getResult();
	}
	
	public function getCategNumber(){
		return $this->getEntityManager()->createQuery(
			"SELECT COUNT(ca.id) FROM AppBundle:Category ca"
		)->getResult();
	}
	
	public function getDisabledNumber(){
		return $this->getEntityManager()->createQuery(
			"SELECT SUM(ca.disable) FROM AppBundle:Category ca"
		)->getResult();
	}

}
?>