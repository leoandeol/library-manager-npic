<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TransactionRepository extends EntityRepository{
		
	public function findAllTypes(){
		return $this->getEntityManager()->createQuery(
			'Select c.id, c.name from AppBundle:Type c'
		)->getResult();
	}
	
	public function findByMemberAndItem($member_code,$item_code){
		return $this->getEntityManager()->createQuery(
			"Select t from AppBundle:Transaction t where t.member = '$member_code' and t.item='$item_code' and t.state='booked' or t.state ='borrowed' "
		)->getResult();
	}
	
	public function findByMember($member_code){
		return $this->getEntityManager()->createQuery(
			"Select t from AppBundle:Transaction t where t.member = '$member_code' "
		)->getResult();
	}
	
}
?>