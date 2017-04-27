<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ItemRepository extends EntityRepository{
	
	
	public function findTotalNumberOfItem(){
		return $this->getEntityManager()->createQuery(
			"SELECT COUNT(it.code)
			FROM AppBundle:item it"
		)->getResult();
	}
	
	public function findAllItems($current,$item_per_page){
		$query = $this->getEntityManager()->createQuery(
			'SELECT it.title,it.author,ca.subject,it.language,it.publication_year,it.bookable,it.note
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id'
		);
		$query->setFirstResult($current);
		$query->setMaxResults($item_per_page);
		return $query->getResult();
	}
	
	public function findTotalNumberOfItemSearched($search){	
		return $this->getEntityManager()->createQuery(
			"SELECT COUNT(it.code)
			FROM AppBundle:item it
			WHERE it.title LIKE '%$search%'"
		)->getResult();
	}
	
	public function findAllItemsSearched($search,$current,$item_per_page){
		$query = $this->getEntityManager()->createQuery(
			"SELECT it.title,it.author,ca.subject,it.language,it.publication_year,it.bookable,it.note
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id
			WHERE it.title LIKE '%$search%'"
		);
		$query->setFirstResult($current);
		$query->setMaxResults($item_per_page);
		return $query->getResult();
	}
}

?>