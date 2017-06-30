<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MOTDRepository extends EntityRepository{

	public function deleteMotd($id){
		$query = $this->getEntityManager()->CreateQuery("
		DELETE AppBundle:MOTD m WHERE m.id = $id
		");
		$query->execute();
	}
}

?>
	