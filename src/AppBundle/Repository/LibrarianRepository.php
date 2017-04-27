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
}

?>