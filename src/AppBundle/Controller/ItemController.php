<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Item;
use AppBundle\Entity\Type;
use AppBundle\Entity\Category;

class ItemController extends Controller
{

    /**
     * @Route("/item/create", name="additem")
     */
    public function CreateAction(Request $request)
    {		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		$type = $em->getRepository('AppBundle:Item')->findAllTypes();
		$category =$em->getRepository('AppBundle:Item')->findAllCategories();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				return $this->render('item/add.html.twig',[
				        'types' => $type,
					'categories' => $category,
					'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
		}
    }
	
	/**
     * @Route("/item/created", name="addeditem")
     */
    public function CreatedAction(Request $request)
    {	
		var_dump($request->request);
		$session = $request->getSession();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if($request->request->get('bookable')==null){
					$bookable = 0;
				}else{
					$bookable = 1;
				}
				if($request->request->get('isbn')==null){
					$isbn = NULL;
				}else{
					$isbn = $request->request->get('isbn');
				}
				
				$em = $this->getDoctrine()->getManager();
				$type = $em->getRepository('AppBundle:Type')->find((int)$request->request->get('type'));
				$category =$em->getRepository('AppBundle:Category')->find((int)$request->request->get('category'));
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
				$new_item->setTotalUnit($request->request->get('units'));
				$new_item->setBorrowedUnit(0);
				$new_item->setCost($request->request->get('cost'));
				$new_item->setDisable(0);
				$new_item->setCategory($category);
				$new_item->setTyppe($type);
				$new_item->setNote(NULL);
				$new_item->setLostUnit(0);
				$new_item->setBookable($bookable);
				$new_item->setAddDate(date("Y-m-d"));
				
				$em->persist($new_item);
				$em->flush();
				return $this->redirect($this->generateUrl('additem'));
			}
			return $this->redirect($this->generateUrl('home'));
		}
		return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route("/item/list/{page}", name="itemlist", requirements={"page": "\d+"})
     */
    public function readAll(Request $request, $page = 1)
    {
		$item_repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Item');
		$total = $item_repository->findTotalNumberOfItem();


		$em = $this->getDoctrine()->getManager();
		$type = $em->getRepository('AppBundle:Item')->findAllTypes();
		$category =$em->getRepository('AppBundle:Item')->findAllCategories();
		
		$item_per_page = 20;
		$nb_max_pages = ceil($total[0][1] / $item_per_page);		
		$current = ($page * $item_per_page) - $item_per_page;
		
		$items = $item_repository->findAllItems($current,$item_per_page);
		
        return $this->render('item/readAll.html.twig',[
			'page_max' => $nb_max_pages,
			'items' => $items,
			'page' => $page,
			'types' => $type,
			'categories' => $category,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
	
	/**
     * @Route("/item/search/{page}", name="itemsearch", requirements={"page": "\d+"})
     */
	 public function search(Request $request, $page = 1)
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

	 /**
	 * @Route("/item/read/{id}", name="readitem", requirements={"id":"\d+"})
	 */
	 public function read(Request $request, $id = -1){
		$em = $this->getDoctrine()->getManager();
		$item = $em->getRepository('AppBundle:Item')->find($id);
		var_dump($item);
         	return $this->render('item/read.html.twig',[
		       'item' => $item,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            ]);
	 }
}
