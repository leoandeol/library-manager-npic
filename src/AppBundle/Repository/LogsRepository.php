<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Logs;

class LogsRepository extends EntityRepository{
	
	public function getLogsNumber(){
		return $this->getEntityManager()->createQuery(
			"SELECT COUNT(lo.id) FROM AppBundle:Logs lo"
		)->getResult();
	}
	
	public function getAllLogs($current,$lib_per_page){
		$query = $this->getEntityManager()->createQuery(
			'SELECT lo
			FROM AppBundle:Logs lo
			'
		);
		$query->setFirstResult($current);
		$query->setMaxResults($lib_per_page);
		return $query->getResult();
	}
}

?>