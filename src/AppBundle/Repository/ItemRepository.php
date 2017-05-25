<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Item;

class ItemRepository extends EntityRepository{

	public function findTop5PopularBooks(){
	       return $this->getEntityManager()->createQuery(
			"SELECT it.title,it.code,it.author,ca.subject,la.lang_name,it.publication_year,it.bookable,it.note
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id
			JOIN AppBundle:Languages la WITH it.language = la.id
			WHERE it.note IS NOT NULL AND it.disable=0
			ORDER BY it.note DESC"
		)->setMaxResults(5)->getResult();
	}

	public function findLast5BooksAdded(){
			$query = $this->getEntityManager()->createQuery(
			"SELECT it.title,it.author,ca.subject,la.lang_name,it.publication_year,it.bookable,it.note,
			it.add_date,it.code
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id
			JOIN AppBundle:Languages la WITH it.language = la.id
			WHERE it.disable=0
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
			WHERE it.disable=0
			GROUP BY tr.item
			");
			$query->setMaxResults(5);
			return $query->getResult();
	}
	
	public function findByCategTypeLanguageSearch($current,$item_per_page,$cat,$type,$lang,$search){
		$query = $this->getEntityManager()->createQuery(
			"SELECT it.code,it.title,it.author,ca.subject,la.lang_name,it.publication_year,it.bookable,it.note,
			it.total_unit
			FROM AppBundle:Item it
			JOIN AppBundle:Type ty WITH it.type = ty.id
			JOIN AppBundle:Category ca WITH it.category = ca.id
			JOIN AppBundle:Languages la WITH it.language = la.id
			WHERE ca.id lIKE '%$cat%' AND ty.id LIKE '%$type%' AND la.id LIKE '%$lang%' AND it.title LIKE '%$search%'
			AND it.disable=0
			"
		);
		$query->setFirstResult($current);
		$query->setMaxResults($item_per_page);
		return $query->getResult();
	}
	
	public function findTotalByCategTypeLanguageSearch($cat,$type,$lang,$search){
		return $this->getEntityManager()->createQuery(
			"SELECT COUNT(it.code)
			FROM AppBundle:Item it
			JOIN AppBundle:Type ty WITH it.type = ty.id
			JOIN AppBundle:Category ca WITH it.category = ca.id
			JOIN AppBundle:Languages la WITH it.language = la.id
			WHERE ca.id lIKE '%$cat%' AND ty.id LIKE '%$type%' AND la.id LIKE '%$lang%' AND it.title LIKE '%$search%'
			AND it.disable=0
			"
		)->getResult();
	}
	
	public function updateNoteByCode($code){
		$query = $this->getEntityManager()->createQuery(
		"UPDATE AppBundle:Item it SET it.note = 
			(SELECT AVG(no.note)
			FROM AppBundle:Note no
			WHERE no.item = $code)
		WHERE it.code = $code
		"
		);
		$query->execute();
	}
	
	public function getItemNumber(){
		return $this->getEntityManager()->createQuery(
		"SELECT COUNT(it.code) FROM AppBundle:Item it"
		)->getResult();
	}
	
	public function getItemUnits(){
		return $this->getEntityManager()->createQuery(
		"SELECT SUM(it.total_unit) FROM AppBundle:Item it"
		)->getResult();
	}
	
	public function getBorrowedUnits(){
		return $this->getEntityManager()->createQuery(
		"SELECT SUM(it.borrowed_unit) FROM AppBundle:Item it"
		)->getResult();
	}
	
	public function getBookedUnits(){
		return $this->getEntityManager()->createQuery(
		"SELECT SUM(it.booked_unit) FROM AppBundle:Item it"
		)->getResult();
	}
	
	public function getLostUnits(){
		return $this->getEntityManager()->createQuery(
		"SELECT SUM(it.lost_unit) FROM AppBundle:Item it"
		)->getResult();
	}
	
	public function getDisabledUnits(){
		return $this->getEntityManager()->createQuery(
		"SELECT SUM(it.disable) FROM AppBundle:Item it"
		)->getResult();
	}
}

?>