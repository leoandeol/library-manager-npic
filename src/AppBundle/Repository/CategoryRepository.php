<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository{

	public function findAllCategories(){
		return $this->getEntityManager()->createQuery(
			'Select c.id, c.subject from AppBundle:Category c where c.disable=0'
		)->getResult();
	}

}
?>