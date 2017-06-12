<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\ItemUnits;
use AppBundle\Entity\Item;
use AppBundle\Entity\Type;
use AppBundle\Entity\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Category;
use AppBundle\Entity\Note;
use AppBundle\Entity\Logs;

class ItemController extends Controller
{

    /**
     * @Route("/item/create/{mode}/{code}", name="additem")
     */
    public function CreateAction(Request $request,$mode, $code = null)
    {		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		$type = $em->getRepository('AppBundle:Type')->findAll();
		$category = $em->getRepository('AppBundle:Category')->findAllCategories();
		$language = $em->getRepository('AppBundle:Languages')->findAll();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				return $this->render('item/add.html.twig',[
					'mode' => $mode,
					'code' => $code,
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
     * @Route("/item/created/{mode}/{id}", name="addeditem")
     */
    public function CreatedAction(Request $request,$mode,$id = null)
    {	
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		
		if($session->get('connected')){
			if($session->get('isAdmin')){
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
				$title = $request->request->get('title');
				$author = $request->request->get('author');
				$publisher = $request->request->get('publisher');
				$pub_year = $request->request->get('publication_year');
				$language = $request->request->get('language');
				$cost = $request->request->get('cost');
				
				if($mode == 'add'){
					$code = $request->request->get('code');
					$units = $request->request->get('units');
				
					if($em->getRepository('AppBundle:Item')->find($code) != null){
						return $this->redirect($this->generateUrl('error',['error'=>'This code is already taken by another item']));
					}
					$new_item = new Item();	
					$new_item->setCode($code);
					$new_item->setDisable(0);		
					$new_item->setTotalUnit($units);
					$new_item->setNote(NULL);
					$new_item->setLostUnit(0);
					$new_item->setBorrowedUnit(0);
					$new_item->setBookedUnit(0);
					$new_item->setAddDate(date("Y-m-d"));
					
					$action = 'Added item $code';
				}else{
					$new_item = $em->getRepository('AppBundle:Item')->find($id);
					$action = "Updated item $id";
					$code = $id;
				}
				
				
				$new_item->setTitle($title);
				$new_item->setAuthor($author);
				$new_item->setPublisher($publisher);
				$new_item->setPublicationYear($pub_year);
				$new_item->setLanguage($em->getRepository('AppBundle:Languages')->find($language));
				$new_item->setIsbn($isbn);
				$new_item->setCost($cost);
				$new_item->setCategory($category);
				$new_item->setTyppe($type);
				$new_item->setBookable($bookable);
				
				$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
				$new_log = new Logs();
				$new_log->setLib($lib);
				$new_log->setLogDate(date('Y-m-d'));
				$new_log->setAction($action);
				$em->persist($new_log);
				
				$em->persist($new_item);
				$em->flush();
				return $this->redirect($this->generateUrl('readitem',['id' => $code]));
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
    }

    /**
     * @Route("/item/list/{page}", name="itemlist", requirements={"page": "\d+"}, options={"expose"=true})
     */
    public function readAllAction(Request $request, $page = 1)
    {
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		$type = $em->getRepository('AppBundle:Type')->findAll();
		$category = $em->getRepository('AppBundle:Category')->findAllCategories();
		$language = $em->getRepository('AppBundle:Languages')->findAll();
		
		
		$search = $request->request->get('Search');
		$cat = $request->request->get('category');
		$typ = $request->request->get('type');
		$lang = $request->request->get('language');
		
		$item_per_page = 15;
		$total = $em->getRepository('AppBundle:Item')->findTotalByCategTypeLanguageSearch($cat,$typ,$lang,$search);
		$nb_max_pages = ceil($total[0][1] / $item_per_page);
		$current = ($page * $item_per_page) - $item_per_page;
		$items = $em->getRepository('AppBundle:Item')->findByCategTypeLanguageSearch($current,$item_per_page,$cat,$typ,$lang,$search);
		
		$data = array(
				'page_max' => $nb_max_pages,
				'languages' => $language,
				'items' => $items,
				'page' => $page,
				'types' => $type,
				'categories' => $category
				);

		if($request->isXmlHttpRequest()){
			return new JsonResponse($data);
		}else{
			return $this->render('item/readAll.html.twig',$data);
		}
    }

	 /**
	 * @Route("/item/read/{id}", name="readitem", options={"expose"=true})
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
					
					$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					$new_log = new Logs();
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$amount = $new_units->getAmount();
					$new_log->setAction("Added $amount units to the item $id");
					$em->persist($new_log);
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
	 * @Route("/item/add_lost_units/{id}", name="add_lost_units", requirements={"id":"\d+"})
	 */
	 public function addLostUnitsAction(Request $request, $id){
		$em = $this->getDoctrine()->getManager();
		$session = $request->getSession();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if(($item = $em->getRepository('AppBundle:Item')->find($id)) != NULL){
					$item->setLostUnit($item->getLostUnit()+$request->request->get('amount'));
					$new_log = new Logs();
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$amount = $request->request->get('amount');
					$new_log->setAction("Added $amount lost units to the item $id");
					$em->persist($new_log);
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
	 * @Route("/item/book/{id}", name="bookitem", requirements={"id":"\d+"}, options={"expose"=true})
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
						if(!$session->get('isAdmin')){
							$user = $membRep->find($session->get('user')->getCode());
							if($transRep->findByMemberAndItem($user->getCode(),$item->getCode()) == NULL){
								if($item->isInStock()){
									if($user->getCurrentBorrowedBooksNb() < 2){
										$new_transaction = new Transaction();
										$new_transaction->setMember($membRep->find($user->getCode()));
										$new_transaction->setItem($item);
										$new_transaction->setFineCostPerDay(0);
										$new_transaction->setState('Booked');
										$new_transaction->setBookedDate(date('Y-m-d'));
										$new_transaction->setFineCostPerDay(1);
										$new_transaction->setFineToPay(0);
										
										$user->setCurrentBorrowedBooksNb($user->getCurrentBorrowedBooksNb()+1);
										$item->setBookedUnit($item->getBookedUnit()+1);
										
										$em->persist($new_transaction);
										$em->flush();
										
										$res = array('msg'=>'Success','code'=>$user->getCode());
									}else{
										$res = 'You reached the limit of items you can borrow.';
									}
								}else{
									$res = 'This item is not available.';
								}
							}else{		
								$res = 'You already booked this item.';
							}
						}else{
							$res = "Administrators can't book items.";
						}
					}else{
						$res = 'This item is not in stock anymore.';
					}
				}else{
					$res = 'This item is disabled.';
				}
			}else{
				$res = "This item doesn't exist.";
			}
		}else{
			$res = 'You must loggin to do this.';
		}
		return new JsonResponse(['data'=>$res]);
	}
	
	/**
	 * @Route("/item/note", name="noteItem", options={"expose"=true})
	 */
	public function noteItemAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$session = $request->getSession();
		$user = $session->get('user');
		$itemCode = $request->request->get('itemCode');
		$item = $em->getRepository('AppBundle:Item')->find($itemCode);
		$user = $em->getRepository('AppBundle:Member')->find($user->getCode());
		$note = $request->request->get('note');
		
		if($session->get('connected')){
			if(!$session->get('isAdmin')){
				if(($oldNote = $em->getRepository('AppBundle:Note')->findBy(
					array('item'=>$itemCode,'member'=>$user->getCode())
				)) == NULL){
					$new_note = new Note();
					$new_note->setMember($user);
					$new_note->setItem($item);
					$new_note->setNote($note);
					
					$em->persist($new_note);
					$em->flush();
					$em->getRepository('AppBundle:Item')->updateNoteByCode($itemCode);
					$em->flush();
					
					$res = 'Success';
				}else{
					$oldNote[0]->setNote($note);
					$em->flush();
					$em->getRepository('AppBundle:Item')->updateNoteByCode($itemCode);
					$em->flush();
					
					$res = 'Success';
				}
			}else{
				$res = 'Administrators are not allowed to do this.';
			}
		}else{
			$res = 'You must loggin to do this.';
		}
		return new JsonResponse(['data'=>$res]);
	}
	
	/**
	 * @Route("/item/getnote", name="getNoteItem", options={"expose"=true})
	 */
	public function getNoteItemAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$session = $request->getSession();
		$user = $session->get('user');
		$itemCode = $request->request->get('itemCode');
		$item = $em->getRepository('AppBundle:Item')->find($itemCode);
		$user = $em->getRepository('AppBundle:Member')->find($user->getCode());
		
		if(($note = $em->getRepository('AppBundle:Note')->findBy(
		array('item'=>$itemCode,'member'=>$user->getCode())
		)) == NULL){
			$res = -1;
		}else{
			$res = $note[0]->getNote();
		}
		
		return new JsonResponse(array('data'=>$res));
	}
}

