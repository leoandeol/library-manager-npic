<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Item;

class ItemController extends Controller
{

    /**
     * @Route("/item/add/", name="additem")
     */
    public function AddAction(Request $request)
    {		
		$session = $request->getSession();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				return $this->render('item/add.html.twig',[
					'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
		}
    }
	
	/**
     * @Route("/item/added/", name="addeditem")
     */
    public function AddedAction(Request $request)
    {	
		$session = $request->getSession();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if(isset($request->request->get('bookable'))){
					$bookable = 1;
				}else{
					$bookable = 0;
				}
				if(isset($request->request->get('isbn'))){
					$isbn = $request->request->get('isbn');
				}else{
					$isbn = NULL;
				}
				
				//TODO IN JS CHECK CODE WITH AJAX
				
				$new_item = new Item();
				
				$new_item->setCode($request->request->get('code'));
				$new_item->setTitle($request->request->get('title'));
				$new_item->setShortTitle($request->request->get('short_title'));
				$new_item->setAuthor($request->request->get('author'));
				$new_item->setPublisher($request->request->get('publisher'));
				$new_item->setPublicationYear($request->request->get('publication_year'));
				$new_item->setLanguage($request->request->get('language'));
				$new_item->setIsbn($isbn);		
				$new_item->setTotalUnit(0);
				$new_item->setBorrowedUnit(0);
				$new_item->setCost($_POST['cost']);
				$new_item->setDisable(0);
				$new_item->setTyppe((int)$_POST['type']);
				$new_item->setCategory((int)$_POST['category']);
				$new_item->setNote(NULL);
				$new_item->setBookable($bookable);
				$new_item->setAddDate(date('Y-m-d'));
				
				$em=$this->getDoctrine()->getManager();
				$em->persist($new_item);
				$em->flush();
			}
		}
    }

    /**
     * @Route("/item/list/{page}", name="itemlist", requirements={"page": "\d+"})
     */
    public function readAll(Request $request, $page = 1)
    {
		$item_repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Item');
		$total = $item_repository->findTotalNumberOfItem();
		
		$item_per_page = 20;
		$nb_max_pages = ceil($total[0][1] / $item_per_page);		
		$current = ($page * $item_per_page) - $item_per_page;
		
		$items = $item_repository->findAllItems($current,$item_per_page);
		
        return $this->render('item/readAll.html.twig',[
			'page_max' => $nb_max_pages,
			'items' => $items,
			'page' => $page,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
	
	/**
     * @Route("/item/search/{page}", name="itemsearch", requirements={"page": "\d+"})
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

        return $this->render('item/readAll.html.twig',[
			'page_max' => $nb_max_pages,
			'items' => $items,
			'page' => $page,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
	 }
}
