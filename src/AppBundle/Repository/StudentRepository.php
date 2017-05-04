<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StudentRepository extends EntityRepository{
	
	public function getStudentID($major,$degree,$year){
		$query = $this->getEntityManager()->createQuery(
			"SELECT stu.id
			FROM AppBundle:Student stu
			WHERE stu.major = :maj AND stu.degree = :deg AND stu.year = :yea
			"
		);
		$query->setParameter('maj',$major);
		$query->setParameter('deg',$degree);
		$query->setParameter('yea',$year);
		return $query->getResult();
	}
}
?>