<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AddressRepository extends EntityRepository{
	
	public function getAddressID($city,$postal_code,$street){
		$query = $this->getEntityManager()->createQuery(
			"SELECT add.id
			FROM AppBundle:Address add
			WHERE add.city = :city AND add.postal_code = :pcode AND add.street LIKE :street
			"
		);
		$query->setParameter('city',$city);
		$query->setParameter('pcode',$postal_code);
		$query->setParameter('street',"%$street%");
		return $query->getResult();
	}
}
?>