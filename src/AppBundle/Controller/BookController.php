<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{

    /**
     * @Route("/book/add/", name="addbook")
     */
    public function AddAction(Request $request)
    {		
        return $this->render('book/add.html.twig',[
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/book/list/{page}", name="booklist", requirements={"page": "\d+"})
     */
    public function readAll(Request $request, $page = 1)
    {
		$item_repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Item');
		$total = $item_repository->findTotalNumberOfItem();
		
		$item_per_page = 20;
		$nb_max_pages = ceil($total[0][1] / $item_per_page);		
		$current = ($page * $item_per_page) - $item_per_page;
		
		$items = $item_repository->findAllItems($current,$item_per_page);
		
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
	 public function read(Request $request, $page = 1)
	 {
		$item_repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Item');
		
		$search = $_POST['Search'];
		
		$total = $item_repository->findTotalNumberOfItemSearched($search);
		
		$item_per_page = 20;
		$nb_max_pages = ceil($total[0][1] / $item_per_page);
		$current = ($page * $item_per_page) - $item_per_page;
		
		$items = $item_repository->findAllItemsSearched($search,$current,$item_per_page);
		
        return $this->render('book/readAll.html.twig',[
			'page_max' => $nb_max_pages,
			'items' => $items,
			'page' => $page,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
	 }
}
