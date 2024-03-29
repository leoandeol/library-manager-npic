<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LibrarianRepository extends EntityRepository{
	
	public function changePassword($newPassword,$username){
		$em = $this->getEntityManager();
		$user = $em->getRepository('AppBundle:Librarian')->find($username);
		$encrypted = hash('sha256', $newPassword);
		if($user != NULL){
			$user->setPassword($encrypted);
			$em->flush();
		}
	}
	
	public function getNumberOfLibrariansWithoutParam(){
			return $this->getEntityManager()->createQuery(
				"SELECT COUNT(lib.username)
				FROM AppBundle:Librarian lib
				"
			)->getResult();
	}
	
	public function getNumberOfLibrarians($username,$fname,$lname){
			$query = $this->getEntityManager()->createQuery(
				"SELECT COUNT(lib.username)
				FROM AppBundle:Librarian lib
				WHERE lib.username LIKE :username AND lib.first_name LIKE :fname AND lib.last_name LIKE :lname
				"
			);
			$query->setParameters(
				array(
					'username' => "%$username%",
					'fname'	   => "%$fname%",
					'lname'    => "%$lname%"
				)
			);
			return $query->getResult();
	}
	
	public function getDisabledNumber(){
		return $this->getEntityManager()->createQuery(
			"SELECT SUM(li.disable) FROM AppBundle:Librarian li"
		)->getResult();
	}
	
	public function getAllLibrarians($current,$lib_per_page,$username,$fname,$lname){
		$query = $this->getEntityManager()->createQuery(
			"SELECT lib.username, lib.first_name, lib.last_name, lib.disable
			FROM AppBundle:Librarian lib
			WHERE lib.username LIKE :username AND lib.first_name LIKE :fname AND lib.last_name LIKE :lname
			"
		);
		$query->setParameters(
				array(
					'username' => "%$username%",
					'fname'	   => "%$fname%",
					'lname'    => "%$lname%"
				)
			);
		$query->setFirstResult($current);
		$query->setMaxResults($lib_per_page);
		return $query->getResult();
	}
	
	public function getGeneralInfos($username){
		$query = $this->getEntityManager()->createQuery(
			"SELECT li.username,li.first_name,li.last_name,li.gender,li.email,
			li.tel,li.hire_date,li.resign_date,li.disable,ad.city,ad.postal_code,
			ad.street
			FROM AppBundle:Librarian li 
			JOIN AppBundle:Address ad WITH li.address = ad.id
			WHERE li.username = :username
			"
		);
		$query->setParameter('username',"$username");
		return $query->getResult();
	}
}

?>