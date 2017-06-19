<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TransactionRepository extends EntityRepository{
	
	public function getToReturnNb($date){
		$query = $this->getEntityManager()->createQuery("
			SELECT COUNT(t)
			FROM AppBundle:Transaction t
			WHERE t.to_return_date = :date AND t.state = 'Borrowed'
		");
		$query->setParameter('date',$date);
		return $query->getResult();
	}
	
	public function findAllTypes(){
		$query = $this->getEntityManager()->createQuery("
		Select c.id, c.name from AppBundle:Type c
		"
		);
		return $query->getResult();
	}
	
	public function findByMemberAndItem($member_code,$item_code){
		$query = $this->getEntityManager()->createQuery("
			Select t from AppBundle:Transaction t 
			where t.member = :member_code and t.item= :item_code and (t.state='booked' or t.state ='borrowed') "
		);
		$query->setParameters(array(
				'member_code' => $member_code,
				'item_code'	  => $item_code
			)
		);
		return $query->getResult();
	}
	
	public function findByMember($member_code){
		$query = $this->getEntityManager()->createQuery("
			Select t from AppBundle:Transaction t where t.member = :member_code and t.state = 'booked' or t.state = 'borrowed' "
		);
		$query->setParameter('member_code',$member_code);
		return $query->getResult();
	}
	
	public function getNumber($t_id,$m_code,$i_title,$borrow_date,$state){
		$query = $this->getEntityManager()->createQuery("
			SELECT COUNT(t) 
			FROM AppBundle:Transaction t
			JOIN AppBundle:Member m WITH t.member = m.code
			JOIN AppBundle:Item i WITH t.item = i.code
			WHERE m.code LIKE :m_code
			AND t.id LIKE :t_id
			AND i.title LIKE :i_title
			AND t.state LIKE :state
			AND (t.borrow_date >= :borrow_date OR t.booked_date >= :borrow_date)
			"
		);
		$query->setParameters(array(
			'm_code' => "%$m_code%",
			't_id'   => "%$t_id%",
			'i_title'=> "%$i_title%",
			'state'  => "%$state%",
			'borrow_date' => $borrow_date
		));
		
		return $query->getResult();
	}
	
	public function getAll($current,$trans_per_page,$t_id,$m_code,$i_title,$borrow_date,$state){
		$query = $this->getEntityManager()->createQuery("
			SELECT t
			FROM AppBundle:Transaction t
			JOIN AppBundle:Member m WITH t.member = m.code
			JOIN AppBundle:Item i WITH t.item = i.code
			WHERE m.code LIKE :m_code
			AND t.id LIKE :t_id
			AND i.title LIKE :i_title
			AND t.state LIKE :state
			AND (t.borrow_date >= :borrow_date OR t.booked_date >= :borrow_date)
			"
		);
		$query->setParameters(array(
			'm_code' => "%$m_code%",
			't_id'   => "%$t_id%",
			'i_title'=> "%$i_title%",
			'state'  => "%$state%",
			'borrow_date' => $borrow_date
		));
		$query->setFirstResult($current);
		$query->setMaxResults($trans_per_page);
		return $query->getResult();
	}
	
}
?>