<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MemberRepository extends EntityRepository{
	
	public function getBookings($code){
		$query = $this->getEntityManager()->createQuery(
			'SELECT tr.id,it.code,it.title,tr.borrow_date
			FROM AppBundle:Member me
			JOIN AppBundle:Transaction tr WITH me.code = tr.member
			JOIN AppBundle:Item it WITH it.code = tr.item
			WHERE me.code = :code
			'
		);
		$query->setParameter('code',$code);		
		return $query->getResult();
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
	
	public function getNumberOfMembers($code,$fname,$lname){
		$query = $this->getEntityManager()->createQuery(
			"SELECT COUNT(me.code)
			FROM AppBundle:Member me
			WHERE me.code LIKE :code AND me.first_name LIKE :fname AND me.last_name LIKE :lname
			"
		);
		$query->setParameters(
			array(
				'code' => "%$code%",
				'fname'=> "%$fname%",
				'lname'=> "%$lname%"
			)
		);		
		return $query->getResult();
	}
	
	public function getAllMembers($current,$mem_per_page,$code,$fname,$lname){
		$query = $this->getEntityManager()->createQuery(
			"SELECT me.code,me.first_name,me.last_name,me.disable
			FROM AppBundle:Member me
			WHERE me.code LIKE :code AND me.first_name LIKE :fname AND me.last_name LIKE :lname
			"
		);
		$query->setParameters(
			array(
				'code' => "%$code%",
				'fname'=> "%$fname%",
				'lname'=> "%$lname%"
			)
		);	
		$query->setFirstResult($current);
		$query->setMaxResults($mem_per_page);
		return $query->getResult();
	}
	
	public function getGeneralInfos($code){
		$query = $this->getEntityManager()->createQuery(
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
		);
		$query->setParameter('code',$code);	
		return $query->getResult();
	}
	
	public function getDisabledNumber(){
		return $this->getEntityManager()->createQuery(
		"SELECT SUM(me.disable) FROM AppBundle:Member me"
		)->getResult();
	}
}

?>