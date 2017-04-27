<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Member;
use AppBundle\Entity\Librarian;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/user/loggedin", name="loggedin")
     */
    public function loggedInAction(Request $request)
    {
		$username = $_POST['Username'];
		$password = $_POST['Password'];
		
		$librarian_repository = $this->getDoctrine()->getManager()->getRepository("AppBundle:Librarian");
		$member_repository = $this->getDoctrine()->getManager()->getRepository("AppBundle:Member");
		
		$session = $request->getSession();
		
		if(($user = $member_repository->find($username)) == NULL){
			if(($user = $librarian_repository->find($username)) == NULL){
				return $this->render('user/wronguser.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			]);
			}
			else{
				if(hash('sha256', $password) == $user->getPassword()){
					$session->set('user',$user);
					$session->set('isAdmin','true');
					$session->set('connected','true');
				}
				else{
					return $this->render('user/wrongpassword.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			]);
				}
			}
		}
		else{
			if(hash('sha256', $password) == $user->getPassword()){	
				$session->set('user',$user);
				$session->set('isadmin','false');
				$session->set('connected','true');
			}
			else{
				return $this->render('user/wrongpassword.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			]);
			}
		}
		if($session->get('connected') == 'true'){
			return $this->render('user/loggedin.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			]);
		}
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
    }

    /**
     * @Route("/user/account", name="account")
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
    }
	
	/**
     * @Route("/user/bookings", name="bookings")
     */
	function checkBookingsAction(Request $request){
		$session = $request->getSession();
		if($session->get('connected')){
			$member_repository = $this->getDoctrine()->getManager()->getRepository("AppBundle:Member");
			if($session->get('isAdmin')){
				$bookings = $member_repository->getBookings($session->get('user')->getUsername());
			}
			else{
				$bookings = $member_repository->getBookings($session->get('user')->getCode());
			}
			return $this->render('user/bookings.html.twig', [
			'bookings' => $bookings,
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			]);
		}
	}
	
    /**
     * @Route("/user/changepass", name="changepass")
     */
    public function ChangePassAction(Request $request)
    {
		$session = $request->getSession();
		if($session->get('connected')){		
			$error = $session->get('error');
			$session->remove('error');
			return $this->render('user/changepass.html.twig', [
				'error' => $error,
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			]);
		}
    }

    /**
     * @Route("/user/changedpass", name="changedpass")
     */
    public function ChangedPassAction(Request $request)
    {
        $session = $request->getSession();
		if($session->get('connected')){
			
			$curpass = $_POST['curpass'];
			$newpass = $_POST['newpass'];
			$newpassbis = $_POST['newpassbis'];
			$changed = false;
			
			if(hash('sha256', $curpass) == $session->get('user')->getPassword()){
				if($newpass == $newpassbis){
					if($session->get('isAdmin')){
						$this->getDoctrine()->getManager()->getRepository('AppBundle:Librarian')->changePassword($newpass,$session->get('user')->getUsername());
					}else{
						$this->getDoctrine()->getManager()->getRepository('AppBundle:Member')->changePassword($newpass,$session->get('user')->getCode());
					}
					$changed = true;
				}
				else{
					$error = "The new passwords aren't corresponding";
					$request->getSession()->set('error', $error);
					return $this->redirect($this->generateUrl('changepass'));
				}
			}
			else{
				$error = "The current password given is wrong";
				$request->getSession()->set('error', $error);
				return $this->redirect($this->generateUrl('changepass'));
			}
			
			if($changed){
				return $this->render('user/changedpass.html.twig', [
					'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				]);
			}
		}
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
			else{
				return $this->redirect($this->generateUrl('home'));
			}
		}
		else{
			return $this->redirect($this->generateUrl('login'));
		}
	}

	/**
     * @Route("/admin/checkAllUser", name="controlpanel")
     */
	public function CheckAllUserAction(Reques $request){
		
	}
}
