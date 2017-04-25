<?php

namespace AppBundle\Controller;

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
		
		$librarian_repository = $this->getDoctrine()->getRepository("AppBundle:Librarian");
		$member_repository = $this->getDoctrine()->getRepository("AppBundle:Member");
		if(($user = $member_repository->find($username)) == NULL){
			if(($user = $librarian_repository->find($username)) == NULL){
				//RAISE EXCEPTION
			}
			else{
				//Connect
				$session = $request->getSession();
				$session->set('connected','true');
			}
		}
		else{
			//Connect
			$session = $request->getSession();
			$session->set('connected','true');
		}
        	
        // database check etc
        return $this->render('user/loggedin.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/user/logout", name="logout")
     */
    public function logoffAction(Request $request)
    {
		$request->getSession()->invalidate();
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/user/account", name="account")
     */
    public function AccountAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('user/account.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/user/changepass", name="changepass")
     */
    public function ChangePassAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('user/changepass.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/user/changedpass", name="changedpass")
     */
    public function ChangedPassAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('user/changedpass.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
