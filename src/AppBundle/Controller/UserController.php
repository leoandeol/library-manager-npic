<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Member;
use AppBundle\Entity\Student;
use AppBundle\Entity\Staff;
use AppBundle\Entity\Librarian;
use AppBundle\Entity\Address;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime; 
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
	
    /**
     * @Route("/user/login", name="login")
     */
    public function loginAction(Request $request)
    {
	// replace this example code with whatever you need
        return $this->render('user/login.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/user/loggedin", name="loggedin", options={"expose"=true})
     */
    public function loggedInAction(Request $request)
    {
		//$username = $_POST['Username'];
		//$password = $_POST['Password'];
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$librarian_repository = $this->getDoctrine()->getManager()->getRepository("AppBundle:Librarian");
		$member_repository = $this->getDoctrine()->getManager()->getRepository("AppBundle:Member");
		
		$session = $request->getSession();
		
		if(($user = $member_repository->find($username)) == NULL){
			if(($user = $librarian_repository->find($username)) == NULL){
				$res = "This user doesn't exist";
			}
			else{
				if(hash('sha256', $password) == $user->getPassword()){
					if($user->getDisable() == 0){
						$session->set('user',$user);
						$session->set('isAdmin',true);
						$session->set('connected',true);
						$res = "Success";
					}else{
						$res = "This user is disabled";
					}
				}else{
					$res = "Wrong password given";
				}
			}
		}
		else{
			if(hash('sha256', $password) == $user->getPassword()){	
				if($user->getDisable() == 0){
					$session->set('user',$user);
					$session->set('isadmin',false);
					$session->set('connected',true);
					$res = "Success";
				}else{
					$res = "This user is disabled";
				}
			}else{
				$res = "Wrong password given";
			}
		}
		return new JsonResponse(array('data' => $res));
    }

    /**
     * @Route("/user/logout", name="logout")
     */
    public function logoffAction(Request $request)
    {
		$session = $request->getSession();
		if($session->get('connected')){
			$session->invalidate();
			// replace this example code with whatever you need
			return $this->redirect('/..');
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
    }

    /**
     * @Route("/user/account", name="account", options={"expose"=true})
     */
    public function accountAction(Request $request)
    {
		$session = $request->getSession();
		if($session->get('connected')){
			return $this->render('user/account.html.twig', [
				'isAdmin' => $session->get('isAdmin'),
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			]);
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
    }
	
	/**
     * @Route("/user/bookings", name="bookings", options={"expose"=true})
     */
	function checkBookingsAction(Request $request){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if(!$session->get('isAdmin')){
				$bookings = $em->getRepository('AppBundle:Transaction')->findByMember($session->get('user')->getCode());
				return $this->render('user/bookings.html.twig', [
				'bookings' => $bookings,
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
    /**
     * @Route("/user/changepass", name="changepass")
     */
    public function ChangePassAction(Request $request)
    {
		$session = $request->getSession();
		if($session->get('connected')){		
			return $this->render('user/changepass.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			]);
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
    }

    /**
     * @Route("/user/changedpass", name="changedpass", options={"expose"=true})
     */
    public function ChangedPassAction(Request $request)
    {
        $session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			
			$curpass = $request->request->get('curpass');
			$newpass = $request->request->get('newpass');
			$newpassbis = $request->request->get('newpassbis');
			
			$changed = false;
			
			if(hash('sha256', $curpass) == $session->get('user')->getPassword()){
				if($newpass == $newpassbis){
					$new = hash('sha256',$newpass);
					if(($user = $em->getRepository('AppBundle:Member')->find($session->get('user')->getCode())) == NULL){
						$user = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
					}
					$user->setPassword($new);
					$em->flush();
					$res = "Success";
				}else{
					$res = "The given passwords are not matching.";
				}
			}else{
				$res = "The current password given is wrong.";
			}
		}else{
			$res = "You must login to do this.";
		}
		return new JsonResponse(array('data'=>$res));
    }
	
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
     * @Route("/admin/checkAllUser/{page}", name="checkalluser", requirements={"page": "\d+"})
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
				
				return $this->render('admin/checkallusers.html.twig', [
					'page_max' => $nb_max_pages,
					'members' => $members,
					'page' => $page,
					'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/checkAllLibs/{page}", name="checkalllib", requirements={"page": "\d+"})
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
				
				return $this->render('admin/checkalllibs.html.twig', [
					'page_max' => $nb_max_pages,
					'libs' => $librarians,
					'page' => $page,
					'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/user/general_infos/{id}", name="general_infos")
     */
	public function CheckGeneralInfosAction(Request $request, $id){
		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		
		if($session->get('connected')){		
			if(!$session->get('isAdmin')){
				if($em->getRepository('AppBundle:Librarian')->find($id) != NULL){
					return $this->redirect($this->generateUrl('errorNotAdmin'));
				}
			}
			if(($user = $em->getRepository('AppBundle:Member')->find($id)) == NULL){
				if(($user = $em->getRepository('AppBundle:Librarian')->find($id)) == NULL){
					return $this->redirect($this->generateUrl('errorNotExistingUser'));
				}else{
					$isMember = false;
				}
			}else{
				$isMember = true;
			}
			return $this->render('user/general_infos.html.twig', [
				'isMember' => $isMember,
				'isAdmin' => $session->get('isAdmin'),
				'user' => $user,
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			]);
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
	/**
     * @Route("/admin/general_infos/{id}", name="library_general_infos",requirements={"id": "\d+"})
     */
	public function CheckGeneralLibraryInfosAction(Request $request){
		
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		
		if($session->get('connected')){
			if($session->get('isAdmin')){
				return $this->render('admin/general_infos.html.twig', [
				'user' => $session->get('user'),
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
			return $this->redirect($this->generateUrl('errorNotAdmin'));
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
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
						$em->flush();
						return $this->redirect($this->generateUrl('checkalluser'));
					}
				}else if(($user = $em->getRepository('AppBundle:Librarian')->find($code)) != NULL){
					$user->setDisable(1);
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
					$em->flush();
					return $this->redirect($this->generateUrl('checkalluser'));
				}else if(($user = $em->getRepository('AppBundle:Librarian')->find($code)) != NULL){
					$user->setDisable(0);
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
}