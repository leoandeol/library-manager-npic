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
    //temporary
        $session = $request->getSession();
		$session->set('connected','true');
        	
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
}
