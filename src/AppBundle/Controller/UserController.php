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
     * @Route("/user/bookings/{id}", name="bookings", options={"expose"=true})
     */
	function checkBookingsAction(Request $request, $id){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				$canCheck = true;
			}else if($session->get('user')->getCode() == $id){
				$canCheck = true;
			}else{
				$canCheck = false;
			}
			if($canCheck){
				$bookings = $em->getRepository('AppBundle:Transaction')->findByMember($id);
				return $this->render('user/bookings.html.twig', [
				'bookings' => $bookings,
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}else{
				return $this->redirect($this->generateUrl('home'));
			}
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
	}
	
		/**
     * @Route("/user/booking/{id}-{code}", name="bookingDetail", options={"expose"=true})
     */
	function checkBookingDetailAction(Request $request, $id, $code){
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			if($session->get('isAdmin')){
				$canCheck = true;
			}else if($session->get('user')->getCode() == $code){
				$canCheck = true;
			}else{
				$canCheck = false;
			}
			if($canCheck){
				$transaction = $em->getRepository('AppBundle:Transaction')->find($id);
				return $this->render('user/booking.html.twig', [
				'transaction' => $transaction,
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}else{
				return $this->redirect($this->generateUrl('home'));
			}
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
     * @Route("/user/general_infos/{id}", name="general_infos", options={"expose"=true})
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
	
	
}