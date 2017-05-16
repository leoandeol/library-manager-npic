<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Item;

class ItemRepository extends EntityRepository{
	
	
	public function findTotalNumberOfItem(){
		return $this->getEntityManager()->createQuery(
			"SELECT COUNT(it.code)
			FROM AppBundle:item it"
		)->getResult();
	}
	
	public function findAllItems($current,$item_per_page){
		$query = $this->getEntityManager()->createQuery(
			'SELECT it.code,it.title,it.author,ca.subject,la.lang_name,it.publication_year,it.bookable,it.note,it.total_unit
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id
			JOIN AppBundle:Languages la WITH it.language = la.id'
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
			"SELECT it.title,it.author,ca.subject,la.lang_name,it.publication_year,it.bookable,it.note
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id
			JOIN AppBundle:Languages la WITH it.language = la.id
			WHERE it.title LIKE '%$search%'");
		$query->setFirstResult($current);
		$query->setMaxResults($item_per_page);
		return $query->getResult();
	}

	public function findTop5PopularBooks(){
	       return $this->getEntityManager()->createQuery(
			"SELECT it.title,it.author,ca.subject,la.lang_name,it.publication_year,it.bookable,it.note
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id
			JOIN AppBundle:Languages la WITH it.language = la.id
			WHERE it.note IS NOT NULL
			ORDER BY it.note DESC"
		)->setMaxResults(5)->getResult();
	}

	public function findLast5BooksAdded(){
			$query = $this->getEntityManager()->createQuery(
			"SELECT it.title,it.author,ca.subject,la.lang_name,it.publication_year,it.bookable,it.note,
			it.add_date
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id
			JOIN AppBundle:Languages la WITH it.language = la.id
			ORDER BY it.add_date DESC");
			$query->setMaxResults(5);
			return $query->getResult();
	}

	public function find5MostPopularBooks(){
			$query = $this->getEntityManager()->createQuery(
			"SELECT it.code,it.title,it.author,ca.subject,la.lang_name,it.publication_year,it.bookable,it.note,
			COUNT(tr.item) AS borrowed
			FROM AppBundle:Transaction tr
			JOIN AppBundle:Item it WITH tr.item = it.code
			JOIN AppBundle:Languages la WITH it.language = la.id
			JOIN AppBundle:Category ca WITH it.category = ca.id
			GROUP BY tr.item
			");
			$query->setMaxResults(5);
			return $query->getResult();
	}
}

?>