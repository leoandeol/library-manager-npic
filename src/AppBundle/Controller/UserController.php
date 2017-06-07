<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Member;
use AppBundle\Entity\Student;
use AppBundle\Entity\Staff;
use AppBundle\Entity\Librarian;
use AppBundle\Entity\Address;
use AppBundle\Entity\Logs;
use AppBundle\Entity\UserLogs;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\FileUploader;
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
		
		$username = $request->request->get('username');
		$password = $request->request->get('password');
		$em =  $this->getDoctrine()->getManager();
		$librarian_repository = $em->getRepository("AppBundle:Librarian");
		$member_repository = $em->getRepository("AppBundle:Member");
		$session = $request->getSession();
		
		if($session->get('Connected')){
			$res = "You are already connected";
		}else{
			if(($user = $member_repository->find($username)) == NULL){
				if(($user = $librarian_repository->find($username)) == NULL){
					$res = "This user doesn't exist";
				}
				else{
					$password = $password.$this->getParameter('nonce');
					if(hash('sha256', $password) == $user->getPassword()){
						if($user->getDisable() == 0){
							$session->set('user',$user);
							$session->set('isAdmin',true);
							$session->set('connected',true);
							$new_log = new Logs();
							$new_log->setLib($user);
							$new_log->setLogDate(date('Y-m-d'));
							$new_log->setAction('Connection');
							$em->persist($new_log);
							$em->flush();
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
				$password = $password.$this->getParameter('nonce');
				if(hash('sha256', $password) == $user->getPassword()){
					if($user->getDisable() == 0){
						$user_log = new UserLogs();
						$user_log->setMember($user);
						$user_log->setLogDate(date('Y-m-d'));
						$user_log->setAction('Connection');
						$em->persist($user_log);
						$em->flush();
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
    }

    /**
     * @Route("/user/logout", name="logout")
     */
    public function logoffAction(Request $request)
    {
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();
		if($session->get('connected')){
			$user = $session->get('user');
			if($session->get('isAdmin')){
				$lib = $em->getRepository('AppBundle:Librarian')->find($user->getUsername());
				$new_log = new Logs();
				$new_log->setLib($lib);
				$new_log->setLogDate(date('Y-m-d'));
				$new_log->setAction('Disconnection');
				$em->persist($new_log);
				$em->flush();
			}else{
				$member = $em->getRepository('AppBundle:Member')->find($user->getCode());
				$user_log = new UserLogs();
				$user_log->setMember($member);
				$user_log->setLogDate(date('Y-m-d'));
				$user_log->setAction('Disconnection');
				$em->persist($user_log);
				$em->flush();
			}
			$session->invalidate();
			// replace this example code with whatever you need
			return $this->redirect('/..');
		}
		return $this->redirect($this->generateUrl('errorNotLogged'));
    }

    /**
     * @Route("/user/account/{code}", name="account", options={"expose"=true})
     */
    public function accountAction(Request $request, $code)
    {
		$em = $this->getDoctrine()->getManager();
		$session = $request->getSession();
		$memb_rep = $em->getRepository('AppBundle:Member');
		$lib_rep = $em->getRepository('AppBundle:Librarian');
		
		if($session->get('connected')){
			$canReadForm = false;
			if($session->get('isAdmin')){
				if(($user = $lib_rep->find($code)) != NULL ){
					$isMember = false;
					if($code == $session->get('user')->getUsername()){
						$id = 'Lib-'.$user->getUsername();
						$form = $this->createFormBuilder($user)
							->add('avatar_path', FileType::class,array('label' => ' ','data_class' => null))
							->add('save', SubmitType::class,array('label' => 'Save',
															'attr'=> array('class'=>'InputAddOn-item'),
															));
						$canReadForm = true;									
					}
				}else{
					$isMember = true;
					$user = $memb_rep->find($code);
				}
			}else{
				if(($user = $lib_rep->find($code)) != NULL ){
					return $this->redirect($this->generateUrl('home'));
				}else{
					$user = $memb_rep->find($code);
					$isMember = true;
					if($code == $session->get('user')->getCode()){
						$id = 'Member-'.$user->getCode();
						$form = $this->createFormBuilder($user)
							->add('avatar_path', FileType::class,array('label' => ' ','data_class' => null))
							->add('save', SubmitType::class,array('label' => 'Save',
																  'attr'=> array('class'=>'InputAddOn-item'),
																));
						$canReadForm = true;
					}
				}
			}
			
			if($canReadForm){
				$form = $form->getForm();
				$form->handleRequest($request);
				$data = ['form' => $form->createView()];
				if($form->isSubmitted() && $form->isValid()){
					$fileUploader = $this->get('fileUploader');
					$fileName = $fileUploader->upload($form['avatar_path']->getData(),$this->getParameter('avatar_directory'),$id);
					$user->setAvatarPath($fileName);
					$session->get('user')->setAvatarPath($fileName);
					$em->persist($user);
					$em->flush();

					$avatar = $fileName;
				}else{
					$avatar = $user->getAvatarPath();
				}
			}else{
				$avatar = $user->getAvatarPath();
			}
			
			$data['user'] = $user;
			$data['avatar'] = $avatar;
			$data['isAdmin'] = $session->get('isAdmin');
			$data['isMember']= $isMember;
			
			return $this->render('user/account.html.twig', ['data' =>$data]);
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
			if($session->get('isAdmin')){
				$user = $em->getRepository('AppBundle:Librarian')->find($session->get('user')->getUsername());
				$id = $user->getUsername();
			}else{
				$user = $em->getRepository('AppBundle:Member')->find($session->get('user')->getCode());						
				$id = $user->getCode();
			}
			$data = array();
			if(hash('sha256', $curpass.$this->getParameter('nonce')) == $user->getPassword()){
				if($newpass == $newpassbis){
					$new = hash('sha256',$newpass.$this->getParameter('nonce'));
					$user->setPassword($new);
					$em->persist($user);
					$em->flush();
					$res = "Success";
					$data['id'] = $id;
				}else{
					$res = "The given passwords are not matching.";
				}
			}else{
				$res = "The current password given is wrong.";
			}
		}else{
			$res = "You must login to do this.";
		}
		$data['res'] = $res;
		return new JsonResponse(array('data' => $data));
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