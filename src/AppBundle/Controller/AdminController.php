<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Member;
use AppBundle\Entity\Student;
use AppBundle\Entity\Staff;
use AppBundle\Entity\Librarian;
use AppBundle\Entity\MOTD;
use AppBundle\Entity\MotdDisplayed;
use AppBundle\Entity\Address;
use AppBundle\Entity\Logs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

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
     * @Route("/admin/showMotd", name="showMotd")
     */
	public function showMotdAction(Request $request){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				$motds = $em->getRepository('AppBundle:MOTD')->findAll();
				return $this->render('admin/showMotd.html.twig', [
					'motds' => $motds,
				]);
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/setMotd/{id}", name="setMotd", options={"expose"=true})
     */
	public function setMotdAction(Request $request, $id = 1){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				$motd = $em->getRepository('AppBundle:MOTD')->find($id);
				$motddisplayed = $em->getRepository('AppBundle:MotdDisplayed')->findAll();
				if($motddisplayed == null){
					$new_motd_displayed = new MotdDisplayed();
					$new_motd_displayed->setContent($this->getParameter('motd_default'));
					$em->persist($new_motd_displayed);
					$em->flush()
				}
				$em->getRepository('AppBundle:MotdDisplayed')->findAll()[0]->setMotdContent($motd->getMotdContent());
				$em->flush();
				return new JsonResponse('Success');
			}
			return new JsonResponse('Only administrators can do this');
		}
		return new JsonResponse('You must login to do this');
	}
	
	/**
     * @Route("/admin/deleteMotd/{id}", name="deleteMotd")
     */
	public function deletetMotdAction(Request $request, $id = 1){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				
				$motddisplayed = $em->getRepository('AppBundle:MotdDisplayed')->findAll()[0];
				$motd = $em->getRepository('AppBundle:MOTD')->find($id);
				$em->getRepository('AppBundle:MOTD')->deleteMotd($id);
				$em->flush();
				if($motddisplayed->getMotdContent() == $motd->getMotdContent()){
					$motds = $em->getRepository('AppBundle:MOTD')->findAll();
					if($motds != null){
						$motddisplayed->setMotdContent($motds->getMotdContent());
					}else{
						$motddisplayed->setMotdContent("");
					}
				}
				$em->flush();
				return $this->redirect($this->generateUrl('showMotd'));
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/addMotd", name="addMotd")
     */
	public function addMotdAction(Request $request){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				$motd = $request->request->get('text');
				$new_motd = new MOTD();
				$new_motd->setMotdContent($motd);
				$motdid = $new_motd->getId();
				$new_log = new Logs();
				$new_log->setLib($em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername()));
				$new_log->setLogDate(date('Y-m-d'));
				$new_log->setAction("Added new motd $motdid");
				
				$em->persist($new_motd);
				$em->persist($new_log);
				$em->flush();
				
				return $this->redirect($this->generateUrl('showMotd'));
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
				
				$code  = $request->request->get('code');
				$fname = $request->request->get('fname');
				$lname = $request->request->get('lname');
				
				$total = $member_rep->getNumberOfMembers($code,$fname,$lname);
				
				$mem_per_page = $this->getParameter('max_per_page');
				$nb_max_pages = ceil($total[0][1] / $mem_per_page);
				$current = ($page * $mem_per_page) - $mem_per_page;
				
				$members = $member_rep->getAllMembers($current,$mem_per_page,$code,$fname,$lname);
				
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
				
				$username  = $request->request->get('username');
				$fname 	   = $request->request->get('fname');
				$lname 	   = $request->request->get('lname');
			
				$lib_rep = $this->getDoctrine()->getManager()->getRepository('AppBundle:Librarian');
				$total = $lib_rep->getNumberOfLibrarians($username,$fname,$lname);
				
				$lib_per_page = $this->getParameter('max_per_page');
				$nb_max_pages = ceil($total[0][1] / $lib_per_page);
				$current = ($page * $lib_per_page) - $lib_per_page;
				
				$librarians = $lib_rep->getAllLibrarians($current,$lib_per_page,$username,$fname,$lname);
				
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
				$logsRep = $em->getRepository('AppBundle:Logs');
				$tranRep = $em->getRepository('AppBundle:Transaction');
				
				$itemNumber   = $itemRep->getItemNumber();
				$itemUnits    = $itemRep->getItemUnits();
				$bItemNumber  = $itemRep->getBorrowedUnits();
				$bookItemNumb = $itemRep->getBookedUnits();
				$lItemNumber  = $itemRep->getLostUnits();
				$dItemNumber  = $itemRep->getDisabledUnits();
				$membNumber   = $membRep->getNumberOfMembersWithoutParam();
				$dMembNumber  = $membRep->getDisabledNumber();
				$libNumber    = $librRep->getNumberOfLibrariansWithoutParam();
				$dLibNumb     = $librRep->getDisabledNumber();
				$categNumb    = $cateRep->getCategNumber();
				$dCategNumb   = $cateRep->getDisabledNumber();
				$typeNumber   = $typeRep->getTypeNumber();
				
				$dateParsed   = explode('-',date('Y-m-d'));
				$thisMonth	  = $dateParsed[0].'-'.$dateParsed[1].'-01';
				$thisYear	  = $dateParsed[1].'01-01';
				$coDay		  = $logsRep->getCo(date('Y-m-d'));
				$coMonth	  = $logsRep->getCo($thisMonth);
				$coYear		  = $logsRep->getCo($thisYear);
				
				$today = date('Y-m-d');
				$tomorrow = date('Y-m-d', strtotime(' + 1 days'));
				$toReturnToday= $tranRep->getToReturnNb($today);
				$toRetTomorrow= $tranRep->getToReturnNb($tomorrow);
				
				$numberItemPerCateg = $itemRep->getNumberPerCateg();
				
				return $this->render('admin/general_infos.html.twig', [
				'nbPerCateg'  => $numberItemPerCateg,
				'toRetToday'  => $toReturnToday,
				'toRetTomor'  => $toRetTomorrow,
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
				'coDay'		  => $coDay,
				'coMonth'	  => $coMonth,
				'coYear'	  => $coYear,
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/add_admin/{mode}/{code}", name="add_admin")
     */
    public function AddAdminAction(Request $request,$mode,$code = null)
    {		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if($mode != 'add'){
					$user = $em->getRepository('AppBundle:Librarian')->find($code);
				}else{
					$user = null;
				}
				return $this->render('admin/add_admin.html.twig',[
					'user' => $user,
					'mode' => $mode,
				    'code' => $code,
				]);
			}
			return $this->redirect($this->generateUrl('home'));
		}
		return $this->redirect($this->generateUrl('login'));
    }

	/**
     * @Route("/admin/add_user/{mode}/{code}", name="add_user")
     */
    public function AddUserAction(Request $request,$mode, $code = null)
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
				if($mode != 'add'){
					$user = $em->getRepository('AppBundle:Member')->find($code);
				}else{
					$user = null;
				}
				return $this->render('admin/add_user.html.twig',[
					'user' => $user,
					'code' => $code,
					'mode' => $mode,
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
     * @Route("/admin/added_user/{mode}/{id}", name="added_user")
     */
    public function AddedUserAction(Request $request,$mode, $id = null)
    {		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		$mem_rep = $em->getRepository('AppBundle:Member');
		if($session->get('connected')){
			if($session->get('isAdmin')){
					
				$dob['day'] = $request->request->get('day');
				$dob['month'] = $request->request->get('month');
				$dob['year'] = $request->request->get('year');
				$dobDataBase = $dob['year'].'-'.$dob['month'].'-'.$dob['day'];
				
				$fname = $request->request->get('fname');
				$lname = $request->request->get('lname');
				$nid = $request->request->get('nid');
				$gender = $request->request->get('gender');
				$mail = $request->request->get('email');
				$hphone = $request->request->get('home_phone');
				$mphone = $request->request->get('mob_phone');
				$rphone = $request->request->get('ref_phone');
				$civsitu = $request->request->get('civsitu');
				$fac = $request->request->get('fac');
				$maj = $request->request->get('major');
				$degree = $request->request->get('degree');
				$degyear = $request->request->get('degree_year');
				$func = $request->request->get('function');
				$city = $request->request->get('city');
				$pcode = $request->request->get('pcode');
				$street = $request->request->get('street');
				$position = $request->request->get('position');
				
				if($mode == 'add'){
					
					$code = $request->request->get('code');
					if($em->getRepository('AppBundle:Member')->find($code) != null){
						return $this->redirect($this->generateUrl('error',['error' => 'This code is already taken by another member']));
					}else{
						$new_member = new Member();
						
						$password = "NPIC".$dob['day'].$dob['month'].$dob['year'];
						$passwordHashed = hash('sha256', $password.$this->getParameter('nonce'));
						
						$new_member->setCode($code);
						$new_member->setPassword($passwordHashed);
						$new_member->setAvatarPath('default_avatar.jpg');
						$new_member->setEntryDate(date("Y-m-d"));
						$new_member->setCurrentBorrowedBooksNb(0);
						$new_member->setDisable(0);
						$action = "Added new member $code";
					}
				}else{
					$new_member = $em->getRepository('AppBundle:Member')->find($id);
					$action = "Updated member $id";
					$code = $id;
				}
				$new_member->setFirstName($fname);
				$new_member->setLastName($lname);
				$new_member->setGender($gender);
				$new_member->setNationalId($nid);
				$new_member->setDob(new \DateTime("$dobDataBase"));
				$new_member->setEmail($mail);
				$new_member->setTelHome($hphone);
				$new_member->setTelMobile($mphone);
				$new_member->setTelRef($rphone);
				$new_member->setCivilSituation($civsitu);
				$new_member->setFaculty($em->getRepository('AppBundle:Faculty')->find($fac));
				
				
				if($position == "student"){
					$new_member->setStudent(true);
					$new_member->setStaff(false);
					$new_member->setMajor($em->getRepository('AppBundle:Major')->find($major));
					$new_member->setDegree($em->getRepository('AppBundle:Degree')->find($degree));
					$new_member->setDegreeYear($em->getRepository('AppBundle:DegreeYear')->find($degyear));
				}else{
					$new_member->setStaff(true);
					$new_member->setStudent(false);
					$new_member->setFunction($em->getRepository('AppBundle:StaffFunction')->find($func));
				}
				
				if(($address_id = $em->getRepository('AppBundle:Address')->getAddressId(
				$city,
				$pcode,
				$street)) != NULL){
					$new_member->setAddress($em->getRepository('AppBundle:Address')->find($address_id[0]["id"]));
				}else{					
					$new_address = new Address();
					$new_address->setCity($city);
					$new_address->setPostalCode($pcode);
					$new_address->setStreet($street);
					$new_member->setAddress($new_address);
					$em->persist($new_address);
				}
				$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
				$new_log = new Logs();
				$new_log->setLib($lib);
				$new_log->setLogDate(date('Y-m-d'));
				$new_log->setAction($action);
				
				$em->persist($new_log);
				$em->persist($new_member);
				$em->flush();

				if($mode == 'add'){
					$this->get('my.mailer')->sendTemplateMessage($request->request->get('email'),"NPIC Library registration completed","email/registration.html.twig",array('username' => $request->request->get('code'), 'password' => $password));	
					return $this->redirect($this->generateUrl('checkalluser'));
				}else{
					return $this->redirect($this->generateUrl('account',['code' => $id]));
				}
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
    }
	
	/**
     * @Route("/admin/added_admin/{mode}/{id}", name="added_admin")
     */
    public function AddedAdminAction(Request $request,$mode, $id = null)
    {		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		$lib_rep = $em->getRepository('AppBundle:Librarian');
		if($session->get('connected')){
			if($session->get('isAdmin')){					
				
				$fname = $request->request->get('fname');
				$lname = $request->request->get('lname');
				$gender = $request->request->get('gender');
				$mail = $request->request->get('email');
				$phone = $request->request->get('phone');
				$city = $request->request->get('city');
				$pcode = $request->request->get('pcode');
				$street = $request->request->get('street');
				
				if($mode == 'add'){	
					
					$username = $request->request->get('username');
					if($em->getRepository('AppBundle:Librarian')->find($username) != null){
						return $this->redirect($this->generateUrl('error',['error' => 'This username already exists']));
					}else{
						$password = $request->request->get('password');
						$passwordHashed = hash('sha256', $password.$this->getParameter('nonce'));
						
						$new_librarian = new Librarian();
						$new_librarian->setAvatarPath('default_avatar.jpg');
						$new_librarian->setHireDate(date("Y-m-d"));
						$new_librarian->setPassword($passwordHashed);
						$new_librarian->setDisable(0);
						$action = "Added new librarian $username";
					}
				}else{
					$new_librarian = $lib_rep->find($id);
					$action = "Updated librarian $id";
					$username = $id;
				}
				
				$new_librarian->setUsername($username);
				$new_librarian->setFirstName($fname);
				$new_librarian->setLastName($lname);
				$new_librarian->setGender($gender);
				$new_librarian->setEmail($mail);
				$new_librarian->setTel($phone);
				
				if(($address_id = $em->getRepository('AppBundle:Address')->getAddressId(
				$city,
				$pcode,
				$street)) != NULL){
					$new_librarian->setAddress($em->getRepository('AppBundle:Address')->find($address_id[0]["id"]));
				}else{					
					$new_address = new Address();
					$new_address->setCity($city);
					$new_address->setPostalCode($pcode);
					$new_address->setStreet($street);
					$new_librarian->setAddress($new_address);
					$em->persist($new_address);
				}
				$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
				$new_log = new Logs();
				$new_log->setLib($lib);
				$new_log->setLogDate(date('Y-m-d'));
				$new_log->setAction($action);
				$em->persist($new_log);
				
				$em->persist($new_librarian);
				$em->flush();
				
				if($mode == 'add'){
					return $this->redirect($this->generateUrl('checkalllib'));
				}else{
					return $this->redirect($this->generateUrl('account',['code' => $username]));
				}
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
						return $this->redirect($this->generateUrl('account',['code'=>$code]));
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
					return $this->redirect($this->generateUrl('account',['code'=>$code]));
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
					return $this->redirect($this->generateUrl('account',['code'=>$code]));
				}else if(($user = $em->getRepository('AppBundle:Librarian')->find($code)) != NULL){
					$user->setDisable(0);
					$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					$new_log = new Logs();
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$new_log->setAction("Reactivated librarian $code");
					$em->persist($new_log);
					$em->flush();
					return $this->redirect($this->generateUrl('account',['code'=>$code]));
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
					return $this->redirect($this->generateUrl('readitem',['id'=>$code]));
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
					return $this->redirect($this->generateUrl('readitem',['id'=>$code]));
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
				$admin = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
				if(($trans = $em->getRepository('AppBundle:Transaction')->find($id)) != NULL){
					$state = $request->request->get('state');
					$oldState = $trans->getState();
					$item  = $em->getRepository('AppBundle:Item')->find($trans->getItem()->getCode());
					$member = $em->getRepository('AppBundle:Member')->find($trans->getMember()->getCode());
					if($state == "Lost"){
						if($oldState == "Booked"){
							$item->setBookedUnit($item->getBookedUnit()-1);
						}else if($oldState == "Borrowed"){
							$item->setBorrowedUnit($item->getBorrowedUnit()-1);
						}
						$item->setLostUnit($item->getLostUnit()+1);
					}else if($state == "Borrowed"){
						if($oldState == "Booked"){
							$trans->setLibForBorrow($admin);
							$item->setBookedUnit($item->getBookedUnit()-1);	
							$trans->setBorrowDate(new \DateTime(date('Y-m-d')));
							$toReturnDate = new \DateTime(date('Y-m-d'));
							$toReturnDate = $toReturnDate->format('Y-m-d');
							$trans->setToReturnDate(date('Y-m-d', strtotime($toReturnDate. ' + 14 days')));
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
					}else if($state == "Finished"){
						if($oldState == "Borrowed"){
							$item->setBorrowedUnit($item->getBorrowedUnit()-1);
							$member->setCurrentBorrowedBooksNb($member->getCurrentBorrowedBooksNb()-1);
							$trans->setReturnDate(new \DateTime(date('Y-m-d')));
							$trans->setLibForReturn($admin);
						}else if($oldState == "Lost"){
							$item->setLostUnit($item->getLostUnit()-1);
						}else if($oldState == "Booked"){
							$item->setBookedUnit($item->getBookedUnit()-1);
						}
					}
					$trans->setState($state);
					if($request->request->get('fineCost') == null){
						$trans->setFineCostPerDay($trans->getFineCostPerDay());
					}else{
						$trans->setFineCostPerDay($request->request->get('fineCost'));
					}
					$lib = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					$new_log = new Logs();
					$new_log->setLib($lib);
					$new_log->setLogDate(date('Y-m-d'));
					$action = "Changed state of transaction $id from $oldState to $state";
					$new_log->setAction($action);
					$em->persist($new_log);
					$em->persist($item);
					$em->persist($member);
					$em->flush();
					return $this->redirect($this->generateUrl('bookingDetail',['id' => $trans->getId(),'code' => $trans->getMember()->getCode()]));
				}else{
					return $this->redirect($this->generateUrl('errorNotExistingItem'));
				}
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/checkBookings/{page}", name="checkBookings", requirements={"page": "\d+"}, options={"expose"=true})
     */
	public function checkBookingsAction(Request $request,$page = 1){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if($request->request->get('m_code') == null){
					$m_code = '';
				}else{
					$m_code = $request->request->get('m_code');
				}
				if($request->request->get('t_id') == null){
					$t_id = '';
				}else{
					$t_id = $request->request->get('t_id');
				}
				if($request->request->get('i_title') == null){
					$i_title = '';
				}else{
					$i_title = $request->request->get('i_title');
				}
				if($request->request->get('state') == null){
					$state = '';
				}else{
					$state = $request->request->get('state');
				}
				$year = $request->request->get('year');
				$month  = $request->request->get('month');
				$day  = $request->request->get('day');
				if($day == null){
					if($month == null){
						if($year == null){	
							$borrow_date = null;
						}
					}
				}else{
					$borrow_date = $year.'-'.$month.'-'.$day;
				}
				$trans_rep = $em->getRepository('AppBundle:Transaction');
				$days = array('day'=>$day,'month'=>$month,'year'=>$year);
				
				$total = $trans_rep->getNumber($t_id,$m_code,$i_title,$borrow_date,$state);
				$trans_per_page = $this->getParameter('max_per_page');
				$nb_max_pages = ceil($total[0][1] / $trans_per_page);
				$current = ($page * $trans_per_page) - $trans_per_page;
				
				$trans = $trans_rep->getAll($current,$trans_per_page,$t_id,$m_code,$i_title,$borrow_date,$state);			
				$serializer = $this->get('serializer');
				$transJson = $serializer->serialize($trans,'json');
			
				if($request->isXmlHttpRequest()){
					$data = array(
						'page_max' => $nb_max_pages,
						'trans' => $transJson,
						'page' => $page,
					);
					return new JsonResponse($data);
				}else{
					$data = array(
						'page_max' => $nb_max_pages,
						'trans' => $trans,
						'page' => $page,
					);
					return $this->render('admin/checkBookings.html.twig',$data);
				}
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
		
	/**
     * @Route("/admin/checkLogs/{page}", name="checkLogs", requirements={"page": "\d+"}, options={"expose"=true})
     */
	public function checkLogsAction(Request $request,$page = 1){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				if($request->request->get('ID') == null){
					$id = '';
				}else{
					$id   = $request->request->get('ID');
				}
				if($request->request->get('who') == null){
					$who = '';
				}else{
					$who  = $request->request->get('who');
				}
				if($request->request->get('what') == null){
					$what = '';
				}else{
					$what  = $request->request->get('what');
				}
				$year = $request->request->get('year');
				$month  = $request->request->get('month');
				$day  = $request->request->get('day');
				if($day  == null){
					if($month  == null){
						if($year  == null){
							$from =  date("2000-01-01");
						}
					}
				}else{
					$from = $year.'-'.$month.'-'.$day;
				}
				$logs_rep = $this->getDoctrine()->getManager()->getRepository('AppBundle:Logs');
				
				$totalToSum = $logs_rep->getLogsNumber($id,$who,$what,$from);
				if($who == ""){
					$total = $totalToSum[0]['total']+$totalToSum[1]['total'];	
				}else{
					$total = $totalToSum[0]['total'];
				}				
				$log_per_page = $this->getParameter('max_per_page');
				$nb_max_pages = ceil($total / $log_per_page);
				$current = ($page * $log_per_page) - $log_per_page;
				
				$logs = $logs_rep->getAllLogs($current,$log_per_page,$id,$who,$what,$from);

				$serializer = $this->get('serializer');
				$logsJson = $serializer->serialize($logs,'json');
				
				
				if($request->isXmlHttpRequest()){
					$data = array(
						'page_max' => $nb_max_pages,
						'logs' => $logsJson,
						'page' => $page,
					);
					return new JsonResponse($data);
				}else{
					$data = array(
						'page_max' => $nb_max_pages,
						'logs' => $logs,
						'page' => $page,
					);
					return $this->render('admin/checkalllogs.html.twig',$data);
				}
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
}
?>
