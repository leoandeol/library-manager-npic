<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FacultyRepository extends EntityRepository{
	
	public function getAllFaculties(){
		$query = $this->getEntityManager()->createQuery(
			'SELECT f.id, f.name FROM AppBundle:Faculty f
			'
		);
		return $query->getResult();
	}
}
?>