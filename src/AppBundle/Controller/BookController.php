<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{

    /**
     * @Route("/book/list/{page}", name="booklist", requirements={"page": "\d+"})
     */
    public function readAll(Request $request, $page = 1)
    {
		$manager = $this->getDoctrine()->getManager();
		$item_repository = $this->getDoctrine()->getRepository('AppBundle:Item');
		
		$query_count = $manager->createQuery(
			'SELECT COUNT(it.code)
			FROM AppBundle:item it'
		);
		$total = $query_count->getResult();
		
		$item_per_page = 20;
		$nb_max_pages = ceil($total[0][1] / $item_per_page);
		
		$current = ($page * $item_per_page) - $item_per_page;
		
		$query_items = $manager->createQuery(
			'SELECT it.title,it.author,ca.subject,it.language,it.publication_year,it.bookable,it.note
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id'
		);
		$query_items->setFirstResult($current);
		$query_items->setMaxResults($item_per_page);
		$items = $query_items->getResult();
		
        return $this->render('book/readAll.html.twig',[
			'page_max' => $nb_max_pages,
			'items' => $items,
			'page' => $page,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
	
	/**
     * @Route("/book/search/{page}", name="booksearch", requirements={"page": "\d+"})
     */
	 public function read(Request $request, $page = 1){
		$manager = $this->getDoctrine()->getManager();
		$item_repository = $this->getDoctrine()->getRepository('AppBundle:Item');
		
		$search = $_POST['Search'];
		
		$query_count = $manager->createQuery(
			"SELECT COUNT(it.code)
			FROM AppBundle:item it
			WHERE it.title LIKE '%$search%'"
		);
		
		$total = $query_count->getResult();		
		$item_per_page = 20;
		$nb_max_pages = ceil($total[0][1] / $item_per_page);
		$current = ($page * $item_per_page) - $item_per_page;
		
		$query_items = $manager->createQuery(
			"SELECT it.title,it.author,ca.subject,it.language,it.publication_year,it.bookable,it.note
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id
			WHERE it.title LIKE '%$search%'"
		);
		$query_items->setFirstResult($current);
		$query_items->setMaxResults($item_per_page);
		$items = $query_items->getResult();
		
        return $this->render('book/readAll.html.twig',[
			'page_max' => $nb_max_pages,
			'items' => $items,
			'page' => $page,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
	 }
}
