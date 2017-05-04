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
	
	public function getGeneralInfos($code){
		return $this->getEntityManager()->createQuery(
			"SELECT me.code,me.first_name,me.last_name,me.national_id,me.civil_situation,
			me.gender,me.dob,me.tel_mobile,me.tel_home,me.tel_ref,me.email,me.entry_date,
			st.id,st.major,st.degree,st.year,ad.city,ad.postal_code,ad.street,fc.name,
			me.disable,me.disable_reason,me.disable_year
			FROM AppBundle:Member me
			JOIN AppBundle:Address ad WITH me.address = ad.id
			JOIN AppBundle:Student st WITH me.student = st.id
			JOIN AppBundle:Faculty fc WITH me.faculty = fc.id
			WHERE me.code = '$code'
			"
		)->getResult();
	}
}

?>