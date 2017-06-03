<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Logs;

class LogsRepository extends EntityRepository{
	
	public function getLogsNumber($id,$who,$what,$from){
		$em = $this->getEntityManager();
		$conn = $em->getConnection();
		if($who == ""){
			$query = $conn->prepare(" 
				SELECT COUNT(lo.id) as total
				FROM Logs lo 
				WHERE lo.librarian_username LIKE '%$id%' AND lo.action LIKE '%$what%'
				AND lo.log_date >= '$from'
				UNION 
				SELECT COUNT(ulo.id)
				FROM UserLogs ulo
				WHERE ulo.member_code LIKE '%$id%' AND ulo.action LIKE '%$what%'
				AND ulo.log_date >= '$from'
			");
		}else if($who == "member"){
			$query = $conn->prepare(" 
				SELECT COUNT(ulo.id) as total
				FROM UserLogs ulo
				WHERE ulo.id LIKE '%$id%' AND ulo.action LIKE '%$what%'
				AND ulo.log_date >= '$from'
			");
		}else{
			$query = $conn->prepare(" 
				SELECT COUNT(lo.id) as total
				FROM Logs lo 
				WHERE lo.id LIKE '%$id%' AND lo.action LIKE '%$what%'
				AND lo.log_date >= '$from'
			");
		}
		$query->execute();
		return $query->fetchAll();
	}
	
	public function getAllLogs($current,$log_per_page,$id,$who,$what,$from){
		$em = $this->getEntityManager();
		$conn = $em->getConnection();
		if($who == ""){
			$query = $conn->prepare(" 
				SELECT *
				FROM Logs lo 
				WHERE lo.librarian_username LIKE '%$id%' AND lo.action LIKE '%$what%'
				AND lo.log_date >= '$from'
				UNION 
				SELECT *
				FROM UserLogs ulo
				WHERE ulo.member_code LIKE '%$id%' AND ulo.action LIKE '%$what%'
				AND ulo.log_date >= '$from'
				LIMIT $current,$log_per_page
			");
		}else if($who == "member"){
			$query = $conn->prepare(" 
				SELECT *
				FROM UserLogs ulo
				WHERE ulo.id LIKE '%$id%' AND ulo.action LIKE '%$what%'
				AND ulo.log_date >= '$from'
				LIMIT $current,$log_per_page
			");
		}else{
			$query = $conn->prepare(" 
				SELECT *
				FROM Logs lo 
				WHERE lo.id LIKE '%$id%' AND lo.action LIKE '%$what%'
				AND lo.log_date >= '$from'
				LIMIT $current,$log_per_page
			");
		}
		$query->execute();
		return $query->fetchAll();
	}
}

?>