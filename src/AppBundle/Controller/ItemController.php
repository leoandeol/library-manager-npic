<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\ItemUnits;
use AppBundle\Entity\Item;
use AppBundle\Entity\Type;
use AppBundle\Entity\Transaction;
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
		$type = $em->getRepository('AppBundle:Type')->findAll();
		$category = $em->getRepository('AppBundle:Category')->findAllCategories();
		$language = $em->getRepository('AppBundle:Languages')->findAll();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				return $this->render('item/add.html.twig',[
					'languages' => $language,
					'types' => $type,
					'categories' => $category,
					'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
    }
	
	/**
     * @Route("/item/created", name="addeditem")
     */
    public function CreatedAction(Request $request)
    {	
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if($em->getRepository('AppBundle:Item')->find($request->request->get('code'))==NULL){
					if($request->request->get('bookable')==null){
						$bookable = "Not available";
					}else{
						$bookable = "Available";
					}
					if($request->request->get('isbn')==null){
						$isbn = NULL;
					}else{
						$isbn = $request->request->get('isbn');
					}
					
					$type = $em->getRepository('AppBundle:Type')->find((int)$request->request->get('type'));
					$category =$em->getRepository('AppBundle:Category')->find((int)$request->request->get('category'));
								
					$new_item = new Item();	
					
					$new_item->setCode($request->request->get('code'));
					$new_item->setTitle($request->request->get('title'));
					$new_item->setShortTitle($request->request->get('short_title'));
					$new_item->setAuthor($request->request->get('author'));
					$new_item->setPublisher($request->request->get('publisher'));
					$new_item->setPublicationYear($request->request->get('publication_year'));
					$new_item->setLanguage($em->getRepository('AppBundle:Languages')->find($request->request->get('language')));
					$new_item->setIsbn($isbn);		
					$new_item->setTotalUnit(0);
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
					return $this->redirect($this->generateUrl('itemlist'));
				}
				return $this->redirect($this->generateUrl('errorAlreadyExistItem'));
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
    }

    /**
     * @Route("/item/list/{page}", name="itemlist", requirements={"page": "\d+"})
     */
    public function readAllAction(Request $request, $page = 1)
    {
		$item_repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Item');
		$total = $item_repository->findTotalNumberOfItem();


		$em = $this->getDoctrine()->getManager();
		$type = $em->getRepository('AppBundle:Type')->findAll();
		$category = $em->getRepository('AppBundle:Category')->findAllCategories();
		$language = $em->getRepository('AppBundle:Languages')->findAll();
		$item_per_page = 20;
		$nb_max_pages = ceil($total[0][1] / $item_per_page);		
		$current = ($page * $item_per_page) - $item_per_page;
		
		$items = $item_repository->findAllItems($current,$item_per_page);
		
		$this->get('acme.js_vars')->items = $items;
		
        return $this->render('item/readAll.html.twig',[
			'method' => 'list',
			'page_max' => $nb_max_pages,
			'languages' => $language,
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
	 public function searchAction(Request $request, $page = 1)
	 {
		$item_repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Item');
		$em = $this->getDoctrine()->getManager();
		$search = $_POST['Search'];
		
		$total = $item_repository->findTotalNumberOfItemSearched($search);
		
		$item_per_page = 20;
		$nb_max_pages = ceil($total[0][1] / $item_per_page);
		$current = ($page * $item_per_page) - $item_per_page;
		
		$items = $item_repository->findAllItemsSearched($search,$current,$item_per_page);
		$type = $em->getRepository('AppBundle:Type')->findAll();
		$category = $em->getRepository('AppBundle:Category')->findAllCategories();
		$language = $em->getRepository('AppBundle:Languages')->findAll();
		
        return $this->render('item/readAll.html.twig',[
			'page_max' => $nb_max_pages,
			'items' => $items,
			'page' => $page,
			'languages' => $language,
			'types' => $type,
			'categories' => $category,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
	 }

	 /**
	 * @Route("/item/read/{id}", name="readitem", requirements={"id":"\d+"}, options={"expose"=true})
	 */
	 public function readAction(Request $request, $id = -1){
		$em = $this->getDoctrine()->getManager();
		if(($item = $em->getRepository('AppBundle:Item')->find($id)) != NULL){
			$type = $em->getRepository('AppBundle:Type')->findAll();
			$category = $em->getRepository('AppBundle:Category')->findAllCategories();
			$language = $em->getRepository('AppBundle:Languages')->findAll();
			return $this->render('item/read.html.twig',[
				   'item' => $item,
				   'types' => $type,
				   'languages' => $language,
				   'categories' => $category,
				   'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			]);
		}
		return $this->redirect($this->generateUrl('errorNotExistingItem'));		
	 }
	 
	 /**
	 * @Route("/item/add_units/{id}", name="add_units", requirements={"id":"\d+"})
	 */
	 public function addUnitsAction(Request $request, $id){
		$em = $this->getDoctrine()->getManager();
		$session = $request->getSession();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if(($item = $em->getRepository('AppBundle:Item')->find($id)) != NULL){
					$new_units = new ItemUnits();
					$new_units->setAmount($request->request->get('amount'));
					$new_units->setItem($em->getRepository('AppBundle:Item')->find($id));
					$new_units->setAddDate(new \DateTime(date('Y-m-d')));
					$em->persist($new_units);
					
					$item = $em->getRepository('AppBundle:item')->find($id);
					$item->setTotalUnit($item->getTotalUnit()+$request->request->get('amount'));
					$em->flush();
					return $this->redirect($this->generateUrl('readitem',['id'=>$id]));
				}
				return $this->redirect($this->generateUrl('errorNotExistingItem'));	
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	 }

	 /**
	 * @Route("/item/book/{id}", name="bookitem", requirements={"id":"\d+"})
	 */
	 public function bookAction(Request $request, $id){
		$em = $this->getDoctrine()->getManager();
		$session = $request->getSession();
		$itemRep = $em->getRepository('AppBundle:Item');
		$transRep = $em->getRepository('AppBundle:Transaction');
		$membRep = $em->getRepository('AppBundle:Member');
		if($session->get('connected')){
			if(($item = $itemRep->find($id)) != NULL){
				if($item->getDisable() == 0){
					if($item->getTotalUnit() > 0){
						$user = $session->get('user');
						if($transRep->findByMemberAndItem($user->getCode(),$item->getCode()) == NULL){
							if($item->isInStock()){
								if($user->getCurrentBorrowedBooksNb() < 2){
									$new_transaction = new Transaction();
									$new_transaction->setMember($membRep->find($user->getCode()));
									$new_transaction->setItem($item);
									$new_transaction->setBorrowdate(new \DateTime(date('Y-m-d')));
									$new_transaction->setFineCostPerDay(0);
									$new_transaction->setState('Booked');
									
									$item->setBorrowedUnit($this->getBorrowedUnit()-1);
									
									$em->persist($new_transaction);
									$em->flush();
									
									return $this->redirect($this->generateUrl('bookings'));
								}
								return $this->redirect($this->generateUrl('errorLimitBorrow'));
							}
							return $this->redirect($this->generateUrl('errorNotAvailable'));
						}						
						return $this->redirect($this->generateUrl('errorAlreadyBooked'));
					}
					return $this->redirect($this->generateUrl('errorNoMoreStock'));
				}
				return $this->redirect($this->generateUrl('errorDisabledItem'));
			}
			return $this->redirect($this->generateUrl('errorNotExistingItem'));	
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/item/sort/{page}", name="sort", requirements={"id":"\d+"})
     */
    public function SortItemAction(Request $request, $page=1)
    {		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		$type = $em->getRepository('AppBundle:Type')->findAll();
		$category = $em->getRepository('AppBundle:Category')->findAllCategories();
		$language = $em->getRepository('AppBundle:Languages')->findAll();
		
		$cat = $request->request->get('category');
		$typ = $request->request->get('type');
		$lang = $request->request->get('language');
		
		$item_per_page = 20;
		$total = $em->getRepository('AppBundle:Item')->findTotalByCategTypeLanguage($cat,$typ,$lang);
		$nb_max_pages = ceil($total[0][1] / $item_per_page);
		$current = ($page * $item_per_page) - $item_per_page;
		$items = $em->getRepository('AppBundle:Item')->findByCategTypeLanguage($current,$item_per_page,$cat,$typ,$lang);
		
		return $this->render('item/readAll.html.twig',[
			'method' => 'sort',
			'page_max' => $nb_max_pages,
			'languages' => $language,
			'items' => $items,
			'page' => $page,
			'types' => $type,
			'categories' => $category,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}

