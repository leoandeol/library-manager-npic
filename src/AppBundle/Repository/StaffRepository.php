<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StaffRepository extends EntityRepository{
	
	public function getStaffID($function){
		$query = $this->getEntityManager()->createQuery(
			"SELECT sta.id
			FROM AppBundle:Staff sta
			WHERE sta.function = :func
			"
		);
		$query->setParameter('func',$function);
		return $query->getResult();
	}
}
?>