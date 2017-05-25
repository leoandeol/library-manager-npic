<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TypeRepository extends EntityRepository{
		
	public function findAllTypes(){
		return $this->getEntityManager()->createQuery(
			'Select c.id, c.name from AppBundle:Type c'
		)->getResult();
	}
	
	public function getTypeNumber(){
		return $this->getEntityManager()->createQuery(
			"SELECT COUNT(ty.id) FROM AppBundle:Type ty"
		)->getResult();
	}
	
	public function getDisabledNumber(){
		return $this->getEntityManager()->createQuery(
			"SELECT SUM(ty.disable) FROM AppBundle:Type ty"
		)->getResult();
	}
	
}
?>