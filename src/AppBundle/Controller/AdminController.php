<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Member;
use AppBundle\Entity\Student;
use AppBundle\Entity\Staff;
use AppBundle\Entity\Librarian;
use AppBundle\Entity\Address;
use AppBundle\Entity\Logs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime; 
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController extends Controller
{
		
	/**
     * @Route("/admin/controlpanel", name="controlpanel")
     */
	public function AccessControlPanelAction(Request $request){
		$session = $request->getSession();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				return $this->render('admin/controlpanel.html.twig', [
					'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/checkAllUser/{page}", name="checkalluser", requirements={"page": "\d+"}, options={"expose"=true})
     */
	public function CheckAllUserAction(Request $request, $page=1){
		$session = $request->getSession();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				
				$member_rep = $this->getDoctrine()->getManager()->getRepository('AppBundle:Member');
				$total = $member_rep->getNumberOfMembers();
				
				$mem_per_page = 20;
				$nb_max_pages = ceil($total[0][1] / $mem_per_page);
				$current = ($page * $mem_per_page) - $mem_per_page;
				
				$members = $member_rep->getAllMembers($current,$mem_per_page);
				
				$data = array(
					'page_max' => $nb_max_pages,
					'members' => $members,
					'page' => $page
				);
				
				if($request->isXmlHttpRequest()){
					return new JsonResponse($data);
				}else{
					return $this->render('admin/checkallusers.html.twig',$data);
				}
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/checkAllLibs/{page}", name="checkalllib", requirements={"page": "\d+"}, options={"expose"=true})
     */
	public function CheckAllLibrarianAction(Request $request, $page=1){
		$session = $request->getSession();
		if($session->get('connected')){
			if($session->get('isAdmin')){
			
				$lib_rep = $this->getDoctrine()->getManager()->getRepository('AppBundle:Librarian');
				$total = $lib_rep->getNumberOfLibrarians();
				
				$lib_per_page = 20;
				$nb_max_pages = ceil($total[0][1] / $lib_per_page);
				$current = ($page * $lib_per_page) - $lib_per_page;
				
				$librarians = $lib_rep->getAllLibrarians($current,$lib_per_page);
				
					$data = array(
					'page_max' => $nb_max_pages,
					'libs' => $librarians,
					'page' => $page,
				);
				
				if($request->isXmlHttpRequest()){
					return new JsonResponse($data);
				}else{
					return $this->render('admin/checkalllibs.html.twig',$data);
				}
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/general_infos/", name="library_general_infos")
     */
	public function CheckGeneralLibraryInfosAction(Request $request){
		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		
		if($session->get('connected')){
			if($session->get('isAdmin')){
				$itemRep = $em->getRepository('AppBundle:Item');
				$membRep = $em->getRepository('AppBundle:Member');
				$librRep = $em->getRepository('AppBundle:Librarian');
				$cateRep = $em->getRepository('AppBundle:Category');
				$typeRep = $em->getRepository('AppBundle:Type');
				
				$itemNumber   = $itemRep->getItemNumber();
				$itemUnits    = $itemRep->getItemUnits();
				$bItemNumber  = $itemRep->getBorrowedUnits();
				$bookItemNumb = $itemRep->getBookedUnits();
				$lItemNumber  = $itemRep->getLostUnits();
				$dItemNumber  = $itemRep->getDisabledUnits();
				$membNumber   = $membRep->getNumberOfMembers();
				$dMembNumber  = $membRep->getDisabledNumber();
				$libNumber    = $librRep->getNumberOfLibrarians();
				$dLibNumb     = $librRep->getDisabledNumber();
				$categNumb    = $cateRep->getCategNumber();
				$dCategNumb   = $cateRep->getDisabledNumber();
				$typeNumber   = $typeRep->getTypeNumber();
				
				return $this->render('admin/general_infos.html.twig', [
				'itemNumber'  => $itemNumber,
				'itemUnits'   => $itemUnits,
				'bItemNumber' => $bItemNumber,     
				'bookItemNumb'=> $bookItemNumb,
				'lItemNumber' => $lItemNumber,
				'dItemNumber' => $dItemNumber,
				'membNumber'  => $membNumber,
				'dMembNumber' => $dMembNumber,
				'libNumber'   => $libNumber,
				'dLibNumb'    => $dLibNumb, 
				'categNumb'   => $categNumb,
				'dCategNumb'  => $dCategNumb, 
				'typeNumber'  => $typeNumber,
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/add_admin/", name="add_admin")
     */
    public function AddAdminAction(Request $request)
    {		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				return $this->render('admin/add_admin.html.twig',[
				    'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
			return $this->redirect($this->generateUrl('home'));
		}
		return $this->redirect($this->generateUrl('login'));
    }

	/**
     * @Route("/admin/add_user/", name="add_user")
     */
    public function AddUserAction(Request $request)
    {		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		$fac = $em->getRepository('AppBundle:Faculty')->getAllFaculties();
		$maj = $em->getRepository('AppBundle:Major')->findAll();
		$deg = $em->getRepository('AppBundle:Degree')->findAll();
		$degYear = $em->getRepository('AppBundle:DegreeYear')->findAll();
		$func = $em->getRepository('AppBundle:StaffFunction')->findAll();
		
		if($session->get('connected')){
			if($session->get('isAdmin')){
				return $this->render('admin/add_user.html.twig',[
				    'functions' => $func,
					'majors' => $maj,
					'degrees' => $deg,
					'degYears' => $degYear,
					'faculties' => $fac,
					'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
			return $this->redirect($this->generateUrl('home'));
		}
		return $this->redirect($this->generateUrl('login'));
    }
	
	/**
     * @Route("/admin/added_user", name="added_user")
     */
    public function AddedUserAction(Request $request)
    {		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		$mem_rep = $em->getRepository('AppBundle:Member');
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if(($mem_rep->find($request->request->get('code'))) == NULL){
					
					$dob['day'] = $request->request->get('day');
					$dob['month'] = $request->request->get('month');
					$dob['year'] = $request->request->get('year');
					
					$password = "NPIC".$dob['day'].$dob['month'].$dob['year'];
					$passwordHashed = hash('sha256', $password);
					
					$dobDataBase = $dob['year'].'-'.$dob['month'].'-'.$dob['day'];
										
					$new_member = new Member();
					$new_member->setCode($request->request->get('code'));
					$new_member->setFirstName($request->request->get('fname'));
					$new_member->setLastName($request->request->get('lname'));
					$new_member->setGender($request->request->get('gender'));
					$new_member->setNationalId($request->request->get('nid'));
					$new_member->setDob(new \DateTime("$dobDataBase"));
					$new_member->setEmail($request->request->get('email'));
					$new_member->setTelHome($request->request->get('home_phone'));
					$new_member->setTelMobile($request->request->get('mob_phone'));
					$new_member->setTelRef($request->request->get('ref_phone'));
					$new_member->setCivilSituation($request->request->get('civsitu'));
					$new_member->setFaculty($em->getRepository('AppBundle:Faculty')->find($request->request->get('fac')));
					$new_member->setEntryDate(date("Y-m-d"));
					$new_member->setPassword($passwordHashed);
					$new_member->setCurrentBorrowedBooksNb(0);
					$new_member->setDisable(0);
					
					$position = $request->request->get('position');
					if($position == "student"){
						$new_member->setStudent(true);
						$new_member->setStaff(false);
						$new_member->setMajor($em->getRepository('AppBundle:Major')->find($request->request->get('major')));
						$new_member->setDegree($em->getRepository('AppBundle:Degree')->find($request->request->get('degree')));
						$new_member->setDegreeYear($em->getRepository('AppBundle:DegreeYear')->find($request->request->get('degree_year')));
					}else{
						$new_member->setStaff(true);
						$new_member->setStudent(false);
						$new_member->setFunction($em->getRepository('AppBundle:StaffFunction')->find($request->request->get('function')));
					}
					
					if(($address_id = $em->getRepository('AppBundle:Address')->getAddressId(
					$request->request->get('city'),
					$request->request->get('pcode'),
					$request->request->get('street'))) != NULL){
						$new_member->setAddress($em->getRepository('AppBundle:Address')->find($address_id[0]["id"]));
					}else{					
						$new_address = new Address();
						$new_address->setCity($request->request->get('city'));
						$new_address->setPostalCode($request->request->get('pcode'));
						$new_address->setStreet($request->request->get('street'));
						$new_member->setAddress($new_address);
						$em->persist($new_address);
					}
					$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					$new_log = new Logs();
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$code = $new_member->getCode();
					$new_log->setAction("Added new member $code");
					$em->persist($new_log);
					
					$em->persist($new_member);
					$em->flush();
					
					return $this->redirect($this->generateUrl('checkalluser'));
				}
				return $this->redirect($this->generateUrl('errorAlreadyExistingUser'));
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
    }
	
	/**
     * @Route("/admin/added_admin", name="added_admin")
     */
    public function AddedAdminAction(Request $request)
    {		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		$lib_rep = $em->getRepository('AppBundle:Librarian');
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if(($lib_rep->find($request->request->get('username'))) == NULL){
					
					$password = $request->request->get('password');
					$passwordHashed = hash('sha256', $password);
					
					$new_librarian = new Librarian();
					$new_librarian->setUsername($request->request->get('username'));
					$new_librarian->setFirstName($request->request->get('fname'));
					$new_librarian->setLastName($request->request->get('lname'));
					$new_librarian->setGender($request->request->get('gender'));
					$new_librarian->setEmail($request->request->get('email'));
					$new_librarian->setTel($request->request->get('phone'));
					$new_librarian->setHireDate(date("Y-m-d"));
					$new_librarian->setPassword($passwordHashed);
					$new_librarian->setDisable(0);
					
					if(($address_id = $em->getRepository('AppBundle:Address')->getAddressId(
					$request->request->get('city'),
					$request->request->get('pcode'),
					$request->request->get('street'))) != NULL){
						$new_librarian->setAddress($em->getRepository('AppBundle:Address')->find($address_id[0]["id"]));
					}else{					
						$new_address = new Address();
						$new_address->setCity($request->request->get('city'));
						$new_address->setPostalCode($request->request->get('pcode'));
						$new_address->setStreet($request->request->get('street'));
						$new_librarian->setAddress($new_address);
						$em->persist($new_address);
					}
					$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					$new_log = new Logs();
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$code = $new_librarian->getUsername();
					$new_log->setAction("Added new librarian $code");
					$em->persist($new_log);
					
					$em->persist($new_librarian);
					$em->flush();
					
					return $this->redirect($this->generateUrl('checkalllib'));
				}
				return $this->redirect($this->generateUrl('errorAlreadyExistingUser'));
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
    }
	
	/**
     * @Route("/admin/disable_user/{code}", name="disable_user")
     */
	public function DisableUserAction(Request $request, $code){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if(($user = $em->getRepository('AppBundle:Member')->find($code)) != NULL){
					if(null==$request->request->get('flag')){
						$flag = false;
					}else{
						$flag = true;
					}
					if(!$flag){
						return $this->render('admin/disable_user_form.html.twig',[
				        'code' => $code,
						'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
						]);
					}else{
						$user->setDisable(1);
						$user->setDisableReason($request->request->get('reason'));
						$user->setDisabledate(date("Y-m-d"));
						$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
						$new_log = new Logs();
						$new_log->setLib($lib);
						$new_log->setLogDate(date('Y-m-d'));
						$new_log->setAction("Disabled member $code");
						$em->persist($new_log);
						$em->flush();
						return $this->redirect($this->generateUrl('checkalluser'));
					}
				}else if(($user = $em->getRepository('AppBundle:Librarian')->find($code)) != NULL){
					$user->setDisable(1);
					$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					$new_log = new Logs();
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$new_log->setAction("Disabled librarian $code");
					$em->persist($new_log);
					$em->flush();
					return $this->redirect($this->generateUrl('checkalllib'));
				}else{
					return $this->redirect($this->generateUrl('errorNotExistingUser'));
				}
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/reactivate_user/{code}", name="reactivate_user")
     */
	public function ReactivateUserAction(Request $request, $code){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if(($user = $em->getRepository('AppBundle:Member')->find($code)) != NULL){
					$user->setDisable(0);
					$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					$new_log = new Logs();
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$new_log->setAction("Reactivated member $code");
					$em->persist($new_log);
					$em->flush();
					return $this->redirect($this->generateUrl('checkalluser'));
				}else if(($user = $em->getRepository('AppBundle:Librarian')->find($code)) != NULL){
					$user->setDisable(0);
					$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					$new_log = new Logs();
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$new_log->setAction("Reactivated librarian $code");
					$em->persist($new_log);
					$em->flush();
					return $this->redirect($this->generateUrl('checkalllib'));
				}else{
					return $this->redirect($this->generateUrl('errorNotExistingUser'));
				}
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/disable_item/{code}", name="disable_item")
     */
	public function DisableItemAction(Request $request, $code){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if(($item = $em->getRepository('AppBundle:Item')->find($code)) != NULL){
					$item->setDisable(1);
					$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					$new_log = new Logs();
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$new_log->setAction("Disabled item $code");
					$em->persist($new_log);
					$em->flush();
					return $this->redirect($this->generateUrl('itemlist'));
				}else{
					return $this->redirect($this->generateUrl('errorNotExistingItem'));
				}
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/reactivate_item/{code}", name="reactivate_item")
     */
	public function ReactivateItemAction(Request $request, $code){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if(($item = $em->getRepository('AppBundle:Item')->find($code)) != NULL){
					$item->setDisable(0);
					$new_log = new Logs();
					$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$new_log->setAction("Reactivated item $code");
					$em->persist($new_log);
					$em->flush();
					return $this->redirect($this->generateUrl('itemlist'));
				}else{
					return $this->redirect($this->generateUrl('errorNotExistingItem'));
				}
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/changeTransactionState/{id}", name="changeTransactionState", requirements={"id":"\d+"})
     */
	public function changeStateTransactionAction(Request $request, $id){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if(($trans = $em->getRepository('AppBundle:Transaction')->find($id)) != NULL){
					$state = $request->request->get('state');
					$oldState = $trans->getState();
					$item  = $trans->getItem();
					if($state == "Lost"){
						if($oldState == "Booked"){
							$item->setBookedUnit($item->getBookedUnit()-1);
						}else if($oldState == "Borrowed"){
							$item->setBorrowedUnit($item->getBorrowedUnit()-1);
						}
						$item->setLostUnit($item->getLostUnit()+1);
					}else if($state == "Borrowed"){
						if($oldState == "Booked"){
							$item->setBookedUnit($item->getBookedUnit()-1);	
							$trans->setBorrowdate(new \DateTime(date('Y-m-d')));
						}else if($oldState == "Lost"){
							$item->setLostUnit($item->getLostUnit()-1);
						}
						$item->setBorrowedUnit($item->getBorrowedUnit()+1);
					}else if($state == "Booked"){
						if($oldState == "Borrowed"){
							$item->setBorrowedUnit($item->getBorrowedUnit()-1);
						}else if($oldState == "Lost"){
							$item->setLostUnit($item->getLostUnit()-1);
						}
						$item->setBookedUnit($item->getBookedUnit()+1);
					}else if($state == "Ended"){
						if($oldState == "Borrowed"){
							$item->setBorrowedUnit($item->getBorrowedUnit()-1);
						}else if($oldState == "Lost"){
							$item->setLostUnit($item->getLostUnit()-1);
						}else if($oldState == "Booked"){
							$item->setBookedUnit($item->getBookedUnit()-1);
						}
					}
					$trans->setState($state);
					$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					$new_log = new Logs();
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$action = "Changed state of transaction $id from $oldState to $state";
					$new_log->setAction($action);
					$em->persist($new_log);
					$em->flush();
					return $this->redirect($this->generateUrl('bookings',['id' => $trans->getMember()->getCode()]));
				}else{
					return $this->redirect($this->generateUrl('errorNotExistingItem'));
				}
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/checkLogs", name="checkLogs", options={"expose"=true})
     */
	public function checkLogsAction(Request $request){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
	}
}

?>