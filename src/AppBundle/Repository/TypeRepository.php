<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TypeRepository extends EntityRepository{
		
	public function findAllTypes(){
		return $this->getEntityManager()->createQuery(
			'Select c.id, c.name from AppBundle:Type c'
		)->getResult();
	}
	
}
?>