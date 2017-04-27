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
	
	public function changePassword($newPassword,$code){
		$em = $this->getEntityManager();
		$user = $em->getRepository('AppBundle:Member')->find($code);
		$encrypted = hash('sha256', $newPassword);
		if($user != NULL){
			$user->setPassword($encrypted);
			$em->flush();
		}
	}
	
	public function getNumberOfMembers(){
		return $this->getEntityManager()->createQuery(
			'SELECT COUNT(me.code)
			FROM AppBundle:Member me
			'
		)->getResult();
	}
	
	public function getAllMembers($current,$mem_per_page){
		$query = $this->getEntityManager()->createQuery(
			'SELECT me.code,me.first_name,me.last_name,me.disable
			FROM AppBundle:Member me
			'
		);
		$query->setFirstResult($current);
		$query->setMaxResults($mem_per_page);
		return $query->getResult();
	}
}

?>