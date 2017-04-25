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
		
		if(!isset($current))
		{ 
			$current = 0;
		}
		
		$query_items = $manager->createQuery(
			'SELECT it.title,it.author,ca.subject,it.language,it.publication_year,it.availability,it.note
			FROM AppBundle:Item it
			JOIN AppBundle:Category ca WITH it.category = ca.id'
		);
		$query_items->setFirstResult($current);
		$query_items->setMaxResults($item_per_page);
		$items = $query_items->getResult();
		
		
        return $this->render('book/readAll.html.twig',[
			'items' => $items,
			'page' => $page,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
