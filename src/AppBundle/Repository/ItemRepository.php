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
	
	public function findAllItems(){
		return $this->getEntityManager()->createQuery(
			'SELECT it.title,it.author,ca.subject,it.language,it.publication_year,it.bookable,it.note
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id'
		);
	}
	
	public function findTotalNumberOfItemSearched($search){	
		return $this->getEntityManager()->createQuery(
			"SELECT COUNT(it.code)
			FROM AppBundle:item it
			WHERE it.title LIKE '%$search%'"
		)->getResult();
	}
	
	public function findAllItemsSearched($search){
		return $this->getEntityManager()->createQuery(
			"SELECT it.title,it.author,ca.subject,it.language,it.publication_year,it.bookable,it.note
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id
			WHERE it.title LIKE '%$search%'"
		);
	}
}

?>