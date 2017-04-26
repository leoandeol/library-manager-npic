<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MemberRepository extends EntityRepository{
	
	public function getBookings($code){
		return $this->getEntityManager()->createQuery(
			'SELECT tr.id,it.title,tr.borrow_date
			FROM AppBundle:Member me
			JOIN AppBundle:Transaction tr WITH me.code = tr.member
			JOIN AppBundle:Item it WITH it.code = tr.item
			'
		)->getResult();
	}
}

?>